<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Response;
use OpenAI\Laravel\Facades\OpenAI;

final class GenerateAiService
{
    /**
     * Create a new class instance.
     */
    public function __invoke(string $prompt): Response
    {
        $apiKey = config('openai.api_key');
        $client = OpenAI::client($apiKey); /** @phpstan-ignore-line */
        $result = $client->chat()->create([/** @phpstan-ignore-line */
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Please generate social media post content based on the following prompt. Generate formatted content with multiple paragraphs. Put hashtags after 2 lines form the main content'.PHP_EOL.PHP_EOL.'Prompt: '.PHP_EOL.$prompt,
                ],
            ],
        ]);

        return response(['content' => $result->choices[0]->message->content]); /** @phpstan-ignore-line */
    }
}
