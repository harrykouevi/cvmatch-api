<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIResumeService
{
    private Client $client;
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'timeout' => 90,
        ]);

        $this->apiKey = config('services.openai.key');
        $this->model = config('services.openai.model', 'gpt-5.5');
    }

    public function analyze(string $resumeText, string $jobDescription): array
    {
        $prompt = $this->buildPrompt($resumeText, $jobDescription);
        try {
            $response = $this->client->post('responses', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'input' => $prompt,
                    'text' => [
                        'format' => [
                            'type' => 'json_object'
                        ]
                    ]
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $output = $data['output'][1]['content'][0]['text'] ?? null;

            if (!$output) {
                return [
                    'success' => false,
                    'message' => 'No response from OpenAI',
                ];
            }

            return [
                'success' => true,
                'data' => json_decode($output, true),
            ];
        } catch (\Throwable $e) {
            Log::error('OpenAI analysis failed', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'AI analysis failed',
            ];
        }
    }


    public function cleanText(string $resumeText): array
    {
        $prompt = $this->buildCleanTextPrompt($resumeText);
        try {
            $response = $this->client->post('responses', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'input' => $prompt,
                    'text' => [
                        'format' => [
                            'type' => 'json_object'
                        ]
                    ]
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $output = $data['output'][1]['content'][0]['text'] ?? null;

            if (!$output) {
                return [
                    'success' => false,
                    'message' => 'No response from OpenAI',
                ];
            }

            return [
                'success' => true,
                'data' => json_decode($output, true),
            ];
        } catch (\Throwable $e) {
            Log::error('OpenAI cleaning text failed', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'AI cleaning text failed',
            ];
        }
    }


    private function buildPrompt(string $resumeText, string $jobDescription): string
    {
        return <<<PROMPT
            You are an expert US resume strategist and ATS optimization specialist.

            Analyze the candidate resume against the job description.

            Return ONLY valid JSON. No markdown. No explanations.

            Use this exact structure:

            {
            "ats_score": 0,
            "match_level": "",
            "job_fit_summary": "",
            "missing_keywords": [],
            "weak_sections": [],
            "strong_points": [],
            "optimized_resume": {
                "full_name": "",
                "headline": "",
                "professional_summary": "",
                "skills": [],
                "professional_experience": [],
                "education": [],
                "languages": []
            },
            "cover_letter": "",
            "recommendations": [],
            "warnings": []
            }

            Rules:
            - Do NOT invent fake experience
            - Use US resume standards
            - Keep output realistic

            Resume:
            $resumeText

            Job description:
            $jobDescription
            PROMPT;
    }

    private function buildCleanTextPrompt(string $text): string
    {
        return <<<PROMPT
            You are a strict text cleaning system.

            Task:
            - Fix encoding issues (UTF-8 corruption, mojibake)
            - Normalize spacing, punctuation, line breaks
            - Preserve ALL information (do NOT summarize, do NOT remove content)
            - Keep original language
            - Improve readability only

            Rules:
            - Output ONLY valid JSON
            - NO markdown
            - NO explanations
            - NO extra text

            Output format:
            {
            "text_clean": "..."
            }

            Input text:
            """
            $text
            """
            PROMPT;
    }

    private function buildPrompt_(string $resumeText, string $jobDescription): string
    {

        return "
            You are an expert US resume strategist and ATS optimization specialist.

            Analyze the candidate resume against the job description.

            Return ONLY valid JSON. No markdown. No explanations outside JSON.

            Use this exact structure:

            {
            \"ats_score\": 0,
            \"match_level\": \"\",
            \"job_fit_summary\": \"\",
            \"missing_keywords\": [],
            \"weak_sections\": [],
            \"strong_points\": [],
            \"optimized_resume\": {
                \"full_name\": \"\",
                \"headline\": \"\",
                \"professional_summary\": \"\",
                \"skills\": [],
                \"professional_experience\": [],
                \"education\": [],
                \"languages\": []
            },
            \"cover_letter\": \"\",
            \"before_after_summary\": [],
            \"recommendations\": [],
            \"warnings\": []
            }

            Rules:
            - Use US resume standards.
            - Do not invent fake experience.
            - Do not add fake employers, fake degrees, fake certifications, or fake dates.
            - Improve wording, structure, relevance, and keyword alignment.
            - Translate and adapt the resume into professional English.
            - Keep the candidate's real experience.
            - Make the resume relevant to the Marketing Engagement Associate Manager role.
            - If the candidate lacks required experience, explain it in warnings.

            Resume:
            {$resumeText}

            Job description:
            {$jobDescription}
        ";
    }
}
