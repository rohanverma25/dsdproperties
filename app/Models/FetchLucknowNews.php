<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\NewsArticle;

class FetchLucknowNews extends Command
{
    // Command name — run with:  php artisan news:fetch
    protected $signature   = 'news:fetch';
    protected $description = 'Fetch top Lucknow real estate news, rewrite with Claude AI, save to DB';

    // ─────────────────────────────────────────────────────
    //  STEP 1: Entry point
    // ─────────────────────────────────────────────────────
    public function handle(): void
    {
        $this->info('▶ Starting news fetch...');

        // Fetch raw articles from NewsAPI
        $articles = $this->fetchFromNewsApi();

        if (empty($articles)) {
            $this->warn('No articles found. Check your NewsAPI key or query.');
            return;
        }

        $this->info('Found ' . count($articles) . ' articles. Rewriting with Claude...');

        $saved = 0;

        foreach ($articles as $article) {
            // Skip articles with no content
            if (empty($article['title']) || empty($article['description'])) {
                continue;
            }

            // Don't save duplicates — check by title
            $alreadyExists = NewsArticle::where('title', $article['title'])->exists();
            if ($alreadyExists) {
                $this->line('  ⏭  Skipping (duplicate): ' . Str::limit($article['title'], 60));
                continue;
            }

            // Rewrite with Claude AI
            $rewritten = $this->rewriteWithClaude($article);

            if (!$rewritten) {
                $this->warn('  ✗ Claude failed for: ' . Str::limit($article['title'], 60));
                continue;
            }

            // Save to database
            NewsArticle::create([
                'title'            => $rewritten['title'],
                'slug'             => $this->makeSlug($rewritten['title']),
                'summary'          => $rewritten['summary'],
                'full_content'     => $rewritten['full_content'],
                'meta_description' => $rewritten['meta_description'],
                'category'         => $rewritten['category'],
                'source_name'      => $article['source']['name'] ?? 'News Source',
                'source_url'       => $article['url'] ?? null,
                'is_hot'           => false,
                'status'           => 'pending',  // YOU review before publishing
            ]);

            $saved++;
            $this->info('  ✓ Saved: ' . Str::limit($rewritten['title'], 60));

            // Small delay to avoid hitting API rate limits
            sleep(1);
        }

        $this->info("✅ Done. {$saved} new articles saved with status = pending.");
        $this->info('   Review them in your admin panel and set status = published.');
    }

    // ─────────────────────────────────────────────────────
    //  STEP 2: Fetch real news from NewsAPI
    //  Get your free key at: https://newsapi.org
    //  Add to .env:  NEWS_API_KEY=your_key_here
    // ─────────────────────────────────────────────────────
    private function fetchFromNewsApi(): array
    {
        $apiKey = config('services.newsapi.key'); // reads from .env

        if (!$apiKey) {
            $this->error('NEWS_API_KEY not set in .env');
            return [];
        }

        // Search query — keeps it hyperlocal
        $query = urlencode('Lucknow real estate OR LDA Lucknow OR IT City Lucknow');

        $url = "https://newsapi.org/v2/everything?"
             . "q={$query}"
             . "&language=en"
             . "&sortBy=publishedAt"       // newest first
             . "&pageSize=5"               // fetch 5 articles per day
             . "&apiKey={$apiKey}";

        $response = file_get_contents($url);

        if (!$response) {
            $this->error('Failed to connect to NewsAPI.');
            return [];
        }

        $data = json_decode($response, true);

        if ($data['status'] !== 'ok') {
            $this->error('NewsAPI error: ' . ($data['message'] ?? 'Unknown error'));
            return [];
        }

        return $data['articles'] ?? [];
    }

    // ─────────────────────────────────────────────────────
    //  STEP 3: Send to Claude — rewrite for Lucknow buyers
    //  Add to .env:  ANTHROPIC_API_KEY=your_key_here
    // ─────────────────────────────────────────────────────
    private function rewriteWithClaude(array $article): ?array
    {
        $apiKey = config('services.anthropic.key'); // reads from .env

        if (!$apiKey) {
            $this->error('ANTHROPIC_API_KEY not set in .env');
            return null;
        }

        // Build the prompt — very specific instructions
        $prompt = <<<PROMPT
You are a real estate news writer for dsdproperties.in, a Lucknow property valuation website.

Here is a raw news article:
Title: {$article['title']}
Content: {$article['description']}
Source: {$article['source']['name']}

Rewrite this for Lucknow property buyers. Return ONLY valid JSON, no markdown, no explanation:

{
  "title": "Rewritten headline (clear, specific, under 90 chars)",
  "summary": "3-4 sentences explaining what happened and why Lucknow buyers should care",
  "full_content": "4-6 paragraphs of detailed content. Explain the news, its impact on Lucknow real estate, which localities are affected, and what buyers/sellers should do. Use simple language.",
  "meta_description": "SEO description under 155 characters summarising the article",
  "category": "one of: lda | it-city | price | projects | policy | rera"
}
PROMPT;

        // Call Claude API
        $response = $this->callAnthropicApi($apiKey, $prompt);

        if (!$response) {
            return null;
        }

        // Parse JSON from Claude's response
        try {
            $text = $response['content'][0]['text'] ?? '';
            // Remove any accidental markdown code fences
            $text = preg_replace('/```json|```/', '', $text);
            $data = json_decode(trim($text), true);

            if (!$data || !isset($data['title'])) {
                $this->warn('  Claude returned invalid JSON.');
                return null;
            }

            return $data;
        } catch (\Exception $e) {
            $this->warn('  JSON parse error: ' . $e->getMessage());
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  HELPER: Make the HTTP call to Anthropic API
    // ─────────────────────────────────────────────────────
    private function callAnthropicApi(string $apiKey, string $prompt): ?array
    {
        $payload = json_encode([
            'model'      => 'claude-sonnet-4-20250514',
            'max_tokens' => 1500,
            'messages'   => [
                ['role' => 'user', 'content' => $prompt]
            ],
        ]);

        // Use cURL (works on any server without extra packages)
        $ch = curl_init('https://api.anthropic.com/v1/messages');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key: ' . $apiKey,
                'anthropic-version: 2023-06-01',
            ],
            CURLOPT_TIMEOUT        => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            $this->warn('  Anthropic API error. HTTP ' . $httpCode);
            return null;
        }

        return json_decode($response, true);
    }

    // ─────────────────────────────────────────────────────
    //  HELPER: Make a unique SEO-friendly slug
    //  "LDA Launches 500 Plots" → "lda-launches-500-plots"
    // ─────────────────────────────────────────────────────
    private function makeSlug(string $title): string
    {
        $slug = Str::slug($title);

        // If slug already exists in DB, add a number suffix
        $original = $slug;
        $count = 1;
        while (NewsArticle::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
