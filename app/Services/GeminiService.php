<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

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
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data'      => $imageBase64,
                ]
            ];
        }

        $response = Http::withQueryParameters(['key' => $this->apiKey])
            ->timeout(30)
            ->post($this->baseUrl, [
                'contents' => [
                    ['parts' => $parts]
                ],
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 2048,
                ]
            ]);

        if ($response->failed()) {
            throw new \Exception('Gemini API error: ' . $response->body());
        }

        return $response->json('candidates.0.content.parts.0.text') ?? '';
    }

    public function generateJson(string $prompt): array
    {
        $result = $this->generate($prompt);
        $clean  = preg_replace('/```json|```/m', '', $result);

        return json_decode(trim($clean), true) ?? [];
    }
}
