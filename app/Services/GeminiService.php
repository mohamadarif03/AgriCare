<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;
    protected $lastResponse;

    public function __construct()
    {
        $this->apiKey  = config('services.gemini.key');
        $this->model   = config('services.gemini.model');
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    public function generate(string $prompt, ?string $imageBase64 = null, ?string $mimeType = null): string
    {
        $parts = [['text' => $prompt]];

        if ($imageBase64 && $mimeType) {
            $parts[] = [
                'inlineData' => [
                    'mimeType' => $mimeType,
                    'data'     => $imageBase64,
                ]
            ];
        }

        $response = Http::withoutVerifying()->retry(3, 2000) // Retry up to 3 times with 2-second delay on 500+ errors
            ->withQueryParameters(['key' => $this->apiKey])
            ->timeout(180)
            ->post($this->baseUrl, [
                'contents' => [
                    ['parts' => $parts]
                ],
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 65536,
                    'responseMimeType' => 'application/json',
                ]
            ]);

        if ($response->failed()) {
            $status = $response->status();
            $body = $response->body();
            if ($status === 429) {
                throw new \Exception("Gemini API Rate Limit Exceeded (429). Server sibuk atau kuota habis: " . $body);
            } elseif ($status >= 500) {
                throw new \Exception("Gemini API Server Error ($status). Server sedang sibuk atau down: " . $body);
            }
            throw new \Exception("Gemini API Error ($status): " . $body);
        }

        $this->lastResponse = $response;
        return $response->json('candidates.0.content.parts.0.text') ?? '';
    }

    public function generateJson(string $prompt, ?string $imageBase64 = null, ?string $mimeType = null): array
    {
        $result = $this->generate($prompt, $imageBase64, $mimeType);
        $clean  = preg_replace('/```json|```/m', '', $result);

        $parsed = json_decode(trim($clean), true);
        if ($parsed === null) {
            $fullResponse = $this->lastResponse ? $this->lastResponse->body() : 'No full response';
            throw new \Exception("Gemini returned invalid JSON. Raw output:\n" . $result . "\n\nFull API Response:\n" . $fullResponse);
        }
        return $parsed;
    }
}
