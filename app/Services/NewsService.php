<?php

// FILE: app/Services/NewsService.php
//
// HOW TO TRIGGER:
//   https://dsdproperties.in/admin/news/fetch?token=YOUR_SECRET_TOKEN&topic=YOUR+TOPIC
//
// EXAMPLE:
//   https://dsdproperties.in/admin/news/fetch
//     ?token=abc123
//     &topic=ED attaches ₹313.12 crore assets in money laundering case against Ansal Group
//
// Set in .env:
//   NEWS_FETCH_TOKEN=put_any_random_string_here
//   ANTHROPIC_API_KEY=xxxx

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\NewsArticle;

class NewsService
{
    // Collects log messages to display in browser
    private array $log = [];

    // ─────────────────────────────────────────────────────
    //  MAIN METHOD
    //  $topic — the raw topic string from the URL parameter
    // ─────────────────────────────────────────────────────
    public function run(string $topic): array
    {
        $topic = trim($topic);

        if (empty($topic)) {
            $this->addLog('error', 'No topic provided. Add ?topic=YOUR+TOPIC to the URL.');
            return $this->result(false, 0);
        }

        $this->addLog('info', '▶ Topic received: ' . $topic);
        $this->addLog('info', 'Sending to Claude with web search enabled...');

        $saved = 0;

        try {

            // STEP 1: Check for duplicate
            $exists = NewsArticle::where('title', 'like', '%' . Str::limit($topic, 50) . '%')->exists();
            if ($exists) {
                $this->addLog('warn', 'A similar article already exists in the database. Skipping.');
                return $this->result(false, $saved);
            }

            // STEP 2: Research + write the article using Claude with web search
            $article = $this->researchAndWrite($topic);

            if (!$article) {
                $this->addLog('error', 'Claude failed to produce an article. Check logs.');
                return $this->result(false, $saved);
            }

            $this->addLog('info', 'Article written: ' . Str::limit($article['title'], 80));

            // STEP 3: Save to database
            try {
                NewsArticle::create([
                    'title'            => $article['title'],
                    'slug'             => $this->makeSlug($article['title']),
                    'summary'          => $article['summary'],
                    'full_content'     => $article['full_content'],
                    'meta_description' => $article['meta_description'],
                    'category'         => $article['category'],
                    'source_name'      => $article['source_name'] ?? null,
                    'source_url'       => $article['source_url']  ?? null,
                    'is_hot'           => false,
                    'status'           => 'pending',
                ]);

                $saved++;
                $this->addLog('success', '✓ Saved with status = pending.');
                Log::info('[NewsService] Article saved', ['title' => $article['title']]);

            } catch (\Exception $e) {
                $this->addLog('error', 'DB save failed: ' . $e->getMessage());
                Log::error('[NewsService] DB save error', ['error' => $e->getMessage()]);
            }

        } catch (\Exception $e) {
            $this->addLog('error', 'Unexpected error: ' . $e->getMessage());
            Log::error('[NewsService] Top-level error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->result(false, $saved);
        }

        $this->addLog('success', "✅ Done! Article saved. Go to /admin/news to review and publish.");
        Log::info('[NewsService] Job completed', ['saved' => $saved]);

        return $this->result(true, $saved);
    }

    // ─────────────────────────────────────────────────────
    //  Research the topic using Claude + web search,
    //  then write the article in one API call.
    //
    //  Claude will:
    //   1. Search the web for real data on the topic
    //   2. Write the article naturally from what it finds
    //   3. Return structured JSON
    // ─────────────────────────────────────────────────────
    private function researchAndWrite(string $topic): ?array
    {
        $apiKey = config('services.anthropic.key');

        if (!$apiKey) {
            $this->addLog('error', 'ANTHROPIC_API_KEY is not set in .env');
            return null;
        }

        // ── System prompt ─────────────────────────────────
        // We tell Claude exactly what we need and how to format it.
        // Crucially: we do NOT dictate length. We let the data drive it.
        $systemPrompt = <<<SYSTEM
You are a real estate news writer for dsdproperties.in, a Lucknow property advisory website.

Your job:
1. Search the web thoroughly for the given news topic using multiple sources.
2. Gather all relevant, accurate facts — figures, dates, names, locations, official statements.
3. Write a news article specifically angled for Lucknow property buyers, investors, and sellers.

Writing rules:
- Write only what the data supports. Do NOT pad or invent content.
- If the topic has rich data, write a detailed article. If data is limited, write a shorter focused one.
- Never force a word count. Natural length is correct length.
- Angle the content toward: how does this affect Lucknow real estate? Which areas/projects are impacted? What should buyers/investors know?
- Use clear, simple language. Human and conversational — not robotic or AI-like.
- For full_content, use basic HTML only: <p>, <strong>, <h3>, <ul>, <li>, <br>. No divs, no classes.
- Do NOT use markdown. Do NOT wrap JSON in code fences.

Output format:
Return ONLY a valid raw JSON object with these keys:

{
  "title": "Clear, specific headline under 90 characters. Engaging for Lucknow real estate readers.",
  "summary": "2-4 sentences. What happened and why it matters for Lucknow property stakeholders. Plain text only.",
  "full_content": "The article body in HTML. Length is driven entirely by available data — could be 2 paragraphs or 8. Whatever is natural and accurate.",
  "meta_description": "SEO meta description under 155 characters.",
  "category": "Exactly one of: lda | it-city | price | projects | policy | rera",
  "source_name": "Name of the primary source used (e.g. Times of India, Economic Times). Empty string if unclear.",
  "source_url": "URL of the primary source article if found. Empty string if not available."
}
SYSTEM;

        // ── User prompt ───────────────────────────────────
        $userPrompt = "Research and write a news article about this topic for Lucknow real estate readers:\n\n{$topic}";

        // ── API payload with web_search tool ─────────────
        $payload = json_encode([
            'model'      => 'claude-sonnet-4-5',
            'max_tokens' => 2500,
            'system'     => $systemPrompt,
            'tools'      => [
                [
                    'type' => 'web_search_20250305',
                    'name' => 'web_search',
                ]
            ],
            'messages' => [
                ['role' => 'user', 'content' => $userPrompt]
            ],
        ]);

        $this->addLog('info', 'Calling Claude API with web search...');
        Log::info('[NewsService] Calling Claude with web search', ['topic' => $topic]);

        try {
            $ch = curl_init('https://api.anthropic.com/v1/messages');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $payload,
                CURLOPT_TIMEOUT        => 60, // web search needs more time
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'x-api-key: ' . $apiKey,
                    'anthropic-version: 2023-06-01',
                    'anthropic-beta: web-search-2025-03-05',
                ],
            ]);

            $response  = curl_exec($ch);
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                $this->addLog('error', 'cURL error: ' . $curlError);
                Log::error('[NewsService] Claude cURL error', ['error' => $curlError]);
                return null;
            }

            if ($httpCode !== 200) {
                $decoded = json_decode($response, true);
                $errMsg  = $decoded['error']['message'] ?? $response;
                $this->addLog('error', "Claude API HTTP {$httpCode}: " . $errMsg);
                Log::error('[NewsService] Claude HTTP error', ['code' => $httpCode, 'body' => $response]);
                return null;
            }

            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addLog('error', 'Claude API response was not valid JSON.');
                Log::error('[NewsService] Claude wrapper JSON error', ['response' => $response]);
                return null;
            }

            // ── Extract the final text block ──────────────
            // With web search enabled, content array has multiple blocks
            // (text, tool_use, tool_result). We want the LAST text block —
            // that is Claude's final answer after searching.
            $textBlocks = array_filter(
                $data['content'] ?? [],
                fn($block) => ($block['type'] ?? '') === 'text'
            );

            if (empty($textBlocks)) {
                $this->addLog('error', 'Claude returned no text content.');
                Log::error('[NewsService] Claude no text blocks', ['data' => $data]);
                return null;
            }

            $text = end($textBlocks)['text'] ?? '';

            if (empty($text)) {
                $this->addLog('error', 'Claude text block was empty.');
                return null;
            }

            // Strip any code fences Claude might have added
            $text = preg_replace('/```json\s*/i', '', $text);
            $text = preg_replace('/```\s*/',      '', $text);
            $text = trim($text);

            // Parse Claude's JSON response
            $parsed = json_decode($text, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addLog('error', 'Could not parse JSON from Claude. Raw: ' . Str::limit($text, 300));
                Log::error('[NewsService] Claude JSON parse error', [
                    'error'    => json_last_error_msg(),
                    'raw_text' => $text,
                ]);
                return null;
            }

            // Validate required fields
            $required = ['title', 'summary', 'full_content', 'meta_description', 'category'];
            foreach ($required as $field) {
                if (empty($parsed[$field])) {
                    $this->addLog('error', "Claude response missing required field: '{$field}'");
                    Log::error('[NewsService] Claude missing field', ['field' => $field]);
                    return null;
                }
            }

            // Validate + normalise category
            if (!isset(\App\Models\NewsArticle::CATEGORIES[$parsed['category']])) {
                $this->addLog('warn', "Unknown category '{$parsed['category']}'. Defaulting to 'policy'.");
                $parsed['category'] = 'policy';
            }

            // Ensure optional fields always exist
            $parsed['source_name'] = $parsed['source_name'] ?? '';
            $parsed['source_url']  = $parsed['source_url']  ?? '';

            $this->addLog('success', 'Claude researched and wrote the article successfully.');
            return $parsed;

        } catch (\Exception $e) {
            $this->addLog('error', 'Exception: ' . $e->getMessage());
            Log::error('[NewsService] Claude exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  Generate a unique SEO slug
    // ─────────────────────────────────────────────────────
    private function makeSlug(string $title): string
    {
        try {
            $slug     = Str::slug($title);
            $original = $slug;
            $count    = 1;

            while (NewsArticle::where('slug', $slug)->exists()) {
                $slug = $original . '-' . $count;
                $count++;
            }

            return $slug;

        } catch (\Exception $e) {
            Log::warning('[NewsService] makeSlug fallback', ['error' => $e->getMessage()]);
            return Str::slug($title) . '-' . time();
        }
    }

    // ─────────────────────────────────────────────────────
    //  Helpers
    // ─────────────────────────────────────────────────────
    private function addLog(string $type, string $message): void
    {
        $this->log[] = [
            'type'    => $type,
            'message' => $message,
            'time'    => now()->format('H:i:s'),
        ];
    }

    private function result(bool $success, int $saved): array
    {
        return [
            'success' => $success,
            'saved'   => $saved,
            'log'     => $this->log,
        ];
    }
}