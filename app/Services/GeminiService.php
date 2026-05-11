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
        $this->apiKey  = config('tanipintar.gemini.api_key');
        $this->model   = config('tanipintar.gemini.model');
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

    public function generateJson(string $prompt, ?string $imageBase64 = null, ?string $mimeType = null, int $maxRetries = 2): array
    {
        $attempts = 0;
        $lastResultRaw = '';

        while ($attempts <= $maxRetries) {
            $result = $this->generate($prompt, $imageBase64, $mimeType);
            $clean  = preg_replace('/```json|```/m', '', $result);
            $clean  = trim($clean);

            $parsed = json_decode($clean, true);
            if ($parsed !== null && json_last_error() === JSON_ERROR_NONE) {
                return $parsed;
            }

            $lastResultRaw = $result;
            $attempts++;
            
            if ($attempts <= $maxRetries) {
                // Jeda 1 detik sebelum mencoba lagi agar terhindar dari spam
                sleep(1);
            }
        }

        $fullResponse = $this->lastResponse ? $this->lastResponse->body() : 'No full response';
        throw new \Exception("Gemini returned invalid JSON after " . ($maxRetries + 1) . " attempts. JSON Error: " . json_last_error_msg() . "\n\nRaw output:\n" . $lastResultRaw . "\n\nFull API Response:\n" . $fullResponse);
    }
}
