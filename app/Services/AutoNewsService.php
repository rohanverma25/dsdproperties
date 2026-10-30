<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\NewsArticle;

/**
 * AutoNewsService
 *
 * Flow:
 *  1. Fetch Google News RSS (searches Lucknow real estate — includes HT, TOI, Jagran, Amar Ujala, ET)
 *  2. Hard-filter: ONLY articles that explicitly mention Lucknow — skip everything else
 *  3. Rewrite each with Groq (LLaMA 3.3 70B) — detailed, 500+ word articles
 *  4. Save as status = published (goes live immediately)
 *
 * Config: GROQ_API_KEY in .env
 */
class AutoNewsService
{
    private array $log = [];

    // Google News RSS — searches for Lucknow real estate news aggregated from all sources
    // Includes: Hindustan Times, Times of India, Jagran, Amar Ujala, Economic Times, NDTV, etc.
    private const FEEDS = [
        // Google News RSS — already curated from trusted sources, skip trusted-source filter
        [
            'url'       => 'https://news.google.com/rss/search?q=lucknow+real+estate+property+LDA+housing&hl=en-IN&gl=IN&ceid=IN:en',
            'source'    => 'Google News',
            'lang'      => 'en',
            'pretrusted' => true,
        ],
        [
            'url'       => 'https://news.google.com/rss/search?q=lucknow+LDA+IT+City+Wellness+City+Varun+Vihar+plot&hl=en-IN&gl=IN&ceid=IN:en',
            'source'    => 'Google News',
            'lang'      => 'en',
            'pretrusted' => true,
        ],
        [
            'url'       => 'https://news.google.com/rss/search?q=लखनऊ+प्रॉपर्टी+LDA+आवास+विकास+मकान+प्लॉट&hl=hi-IN&gl=IN&ceid=IN:hi',
            'source'    => 'Google News',
            'lang'      => 'hi',
            'pretrusted' => true,
        ],
        // Direct feeds — apply trusted-source filter
        [
            'url'       => 'https://www.hindustantimes.com/feeds/rss/real-estate/rssfeed.xml',
            'source'    => 'Hindustan Times',
            'lang'      => 'en',
            'pretrusted' => false,
        ],
        [
            'url'       => 'https://www.amarujala.com/rss/uttar-pradesh.xml',
            'source'    => 'Amar Ujala',
            'lang'      => 'hi',
            'pretrusted' => false,
        ],
    ];

    // STRICT: article must contain at least one of these to be accepted
    // No Lucknow mention = skipped entirely
    private const LUCKNOW_REQUIRED = [
        // City name
        'lucknow', 'lko', 'लखनऊ',

        // Authorities & bodies
        'lda', 'lucknow development authority',
        'awas vikas', 'upavp', 'up avas vikas',
        'up rera lucknow', 'nagar nigam lucknow', 'lmc lucknow',
        'upeida lucknow',

        // LDA schemes & projects
        'it city', 'wellness city', 'varun vihar', 'naimish nagar',
        'saumitra vihar', 'anant nagar', 'atal nagar lucknow',
        'ai city lucknow', 'park view apartments lucknow',
        'lake view apartments', 'narmada apartment', 'aishbagh square',
        'basant kunj lucknow', 'lda plot lottery', 'lda scheme',
        'vrindavan yojna', 'vrindavan sector',

        // Major localities & areas
        'gomti nagar', 'gomti nagar extension',
        'sultanpur road', 'kisan path', 'sushant golf city',
        'shaheed path', 'vibhuti khand', 'hazratganj',
        'indira nagar', 'aliganj', 'mahanagar', 'chinhat',
        'mohanlalganj', 'bakshi ka talab', 'bkt lucknow',
        'faizabad road lucknow', 'raebareli road lucknow',
        'kanpur road lucknow', 'hardoi road lucknow',
        'sitapur road lucknow', 'ring road lucknow',
        'outer ring road lucknow', 'kalindi park',
        'rajajipuram', 'alambagh', 'charbagh',
        'aminabad', 'hussainganj', 'nishatganj',
        'vikas nagar lucknow', 'jankipuram', 'sarojini nagar lucknow',
        'telibagh', 'aashiyana lucknow', 'transport nagar lucknow',
        'munshi pulia', 'nirala nagar', 'kapoorthala',
        'patrakarpuram', 'viraj khand', 'vinay khand',

        // Infrastructure
        'lucknow metro', 'lucknow airport', 'amausi airport',
        'lucknow expressway', 'agra lucknow expressway',
        'awadh expressway lucknow',

        // General property terms with lucknow
        'lucknow property', 'lucknow real estate', 'lucknow housing',
        'lucknow flat', 'lucknow plot', 'lucknow apartment',
        'lucknow registry', 'lucknow builder', 'lucknow colony',
    ];

    // SECOND FILTER: article must also mention at least one real estate keyword
    // This stops general Lucknow news (crime, weather, politics) from leaking in
    private const REALESTATE_REQUIRED = [
        // English
        'real estate', 'property', 'housing', 'flat', 'apartment', 'plot',
        'builder', 'developer', 'colony', 'scheme', 'registry', 'registration',
        'stamp duty', 'mutation', 'allotment', 'possession', 'rera',
        'lda', 'awas vikas', 'upavp', 'it city', 'wellness city',
        'varun vihar', 'naimish nagar', 'saumitra vihar', 'vrindavan yojna',
        'gomti nagar', 'shaheed path', 'sultanpur road', 'kisan path',
        'sushant golf', 'residential', 'commercial property', 'home loan',
        'investment', 'floor price', 'circle rate', 'lease', 'freehold',
        // Hindi
        'प्रॉपर्टी', 'मकान', 'आवास', 'प्लॉट', 'फ्लैट', 'भूमि', 'जमीन',
        'रजिस्ट्री', 'आवास विकास', 'योजना', 'भवन', 'निर्माण', 'किराया',
        'नक्शा', 'अवैध कॉलोनी', 'एलडीए', 'रेरा', 'आवंटन',
    ];

    // Trusted sources — skip articles from unknown/spam sites
    private const TRUSTED_SOURCES = [
        'hindustan times', 'hindustantimes',
        'times of india', 'timesofindia',
        'economic times', 'economictimes',
        'jagran', 'dainik jagran',
        'amar ujala', 'amarujala',
        'ndtv', 'business standard', 'livemint', 'mint',
        'navbharat times', 'nbt',
        'etgovernment', 'et realty', 'etrealty',
        'newsroom post', 'moneycontrol',
    ];

    private const MAX_ARTICLES = 5;
    private const GROQ_API_URL = 'https://api.groq.com/openai/v1/chat/completions';
    private const GROQ_MODEL   = 'llama-3.3-70b-versatile';

    // ─────────────────────────────────────────────────────
    //  MAIN
    // ─────────────────────────────────────────────────────
    public function run(): array
    {
        $this->info('Starting daily news fetch — ' . now()->setTimezone('Asia/Kolkata')->format('d M Y, H:i'));

        $groqKey = config('services.groq.key');
        if (!$groqKey) {
            $this->error('GROQ_API_KEY is not set in .env — get free key at console.groq.com');
            return $this->result(false, 0);
        }

        $items = $this->fetchRssItems();

        if (empty($items)) {
            $this->warn('No Lucknow real estate news found today.');
            return $this->result(false, 0);
        }

        $this->info('Found ' . count($items) . ' Lucknow article(s). Rewriting with Groq...');
        $saved = 0;

        foreach ($items as $item) {
            $titleSnippet = Str::limit($item['title'], 55);

            if (NewsArticle::where('title', 'like', '%' . $titleSnippet . '%')->exists()) {
                $this->skip('Already in DB: ' . $titleSnippet);
                continue;
            }

            $article = $this->rewriteWithGroq($item, $groqKey);

            if (!$article) {
                $this->warn('Groq failed for: ' . $titleSnippet);
                continue;
            }

            try {
                NewsArticle::create([
                    'title'            => trim($article['title']),
                    'slug'             => $this->makeSlug($article['title']),
                    'summary'          => trim($article['summary'] ?? ''),
                    'full_content'     => trim($article['full_content']),
                    'meta_description' => trim($article['meta_description'] ?? ''),
                    'category'         => $this->normaliseCategory($article['category'] ?? ''),
                    'source_name'      => $item['source_name'],
                    'source_url'       => $item['url'] ?? '',
                    'is_hot'           => false,
                    'status'           => 'published',  // goes live immediately
                ]);

                $saved++;
                $this->success('Published: ' . Str::limit($article['title'], 70));
                Log::info('[AutoNewsService] Published', ['title' => $article['title']]);

            } catch (\Exception $e) {
                $this->error('DB error: ' . $e->getMessage());
                Log::error('[AutoNewsService] DB error', ['error' => $e->getMessage()]);
            }

            sleep(6); // ~2000 tokens per call × 5 calls = 10k tokens/min — stays under 12k TPM limit
        }

        $msg = "Done. {$saved} article(s) published.";
        $saved > 0 ? $this->success($msg) : $this->warn($msg);

        return $this->result($saved > 0, $saved);
    }

    // ─────────────────────────────────────────────────────
    //  Fetch RSS, apply strict Lucknow filter, return top items
    // ─────────────────────────────────────────────────────
    private function fetchRssItems(): array
    {
        $items  = [];
        $cutoff = now()->subHours(48)->getTimestamp();

        foreach (self::FEEDS as $feed) {
            $this->info('Fetching: ' . $feed['source']);
            $xml = $this->fetchXml($feed['url']);

            if (!$xml) {
                $this->warn('Could not fetch: ' . $feed['source']);
                continue;
            }

            foreach ($xml->channel->item as $item) {
                $title = trim((string) ($item->title ?? ''));
                $desc  = trim(strip_tags((string) ($item->description ?? '')));
                $url   = trim((string) ($item->link ?? $item->guid ?? ''));
                $pub   = strtotime((string) ($item->pubDate ?? '')) ?: 0;

                // For Google News, <source> element holds the actual publisher name
                // e.g. <source url="https://...">Hindustan Times</source>
                $sourceName = trim((string) ($item->source ?? ''));
                if (empty($sourceName)) {
                    $sourceName = $feed['source'];
                }

                if (empty($title) || $pub < $cutoff) {
                    continue;
                }

                $combined = strtolower($title . ' ' . $desc . ' ' . $sourceName);

                // FILTER 1: must mention Lucknow or a Lucknow landmark/scheme
                $isLucknow = false;
                foreach (self::LUCKNOW_REQUIRED as $kw) {
                    if (str_contains($combined, strtolower($kw))) {
                        $isLucknow = true;
                        break;
                    }
                }
                if (!$isLucknow) {
                    continue;
                }

                // FILTER 2: must also be about real estate (stops crime/weather/politics)
                $isRealEstate = false;
                foreach (self::REALESTATE_REQUIRED as $kw) {
                    if (str_contains($combined, strtolower($kw))) {
                        $isRealEstate = true;
                        break;
                    }
                }
                if (!$isRealEstate) {
                    continue;
                }

                // FILTER 3: trusted source — skip for Google News (already curated)
                if (!$feed['pretrusted']) {
                    $isTrusted = false;
                    foreach (self::TRUSTED_SOURCES as $ts) {
                        if (str_contains($combined, $ts)) {
                            $isTrusted = true;
                            break;
                        }
                    }
                    if (!$isTrusted) {
                        continue;
                    }
                }

                $items[] = [
                    'title'       => $title,
                    'desc'        => Str::limit($desc, 600),
                    'url'         => $url,
                    'source'      => $feed['source'],
                    'source_name' => $sourceName ?: $feed['source'],
                    'lang'        => $feed['lang'],
                    'pubDate'     => $pub,
                ];
            }

            $this->info($feed['source'] . ' — done.');
        }

        // Sort newest first, deduplicate by URL
        usort($items, fn($a, $b) => $b['pubDate'] - $a['pubDate']);

        $seen  = [];
        $dedup = [];
        foreach ($items as $item) {
            if (!in_array($item['url'], $seen) && !in_array($item['title'], $seen)) {
                $seen[]  = $item['url'];
                $seen[]  = $item['title'];
                $dedup[] = $item;
            }
        }

        $this->info('Lucknow articles found: ' . count($dedup));
        return array_slice($dedup, 0, self::MAX_ARTICLES);
    }

    // ─────────────────────────────────────────────────────
    //  Fetch and parse XML from URL
    // ─────────────────────────────────────────────────────
    private function fetchXml(string $url): ?\SimpleXMLElement
    {
        try {
            $ctx = stream_context_create([
                'http' => [
                    'timeout'       => 12,
                    'user_agent'    => 'Mozilla/5.0 (compatible; DSDPropertiesBot/1.0)',
                    'ignore_errors' => true,
                ],
                'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false],
            ]);

            $raw = @file_get_contents($url, false, $ctx);

            if (!$raw || (!str_contains($raw, '<rss') && !str_contains($raw, '<feed'))) {
                return null;
            }

            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($raw);
            libxml_clear_errors();

            return $xml ?: null;

        } catch (\Exception $e) {
            Log::warning('[AutoNewsService] RSS fetch failed', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  Rewrite one article using Groq — detailed, 500+ words
    // ─────────────────────────────────────────────────────
    private function rewriteWithGroq(array $item, string $apiKey): ?array
    {
        $langNote = $item['lang'] === 'hi'
            ? 'The source article is in Hindi. Understand it fully and write your output in English.'
            : '';

        $systemPrompt = <<<SYSTEM
You are a senior real estate news writer for dsdproperties.in, a property advisory firm in Lucknow, UP.

Your job: take a raw news item and write a detailed, informative article specifically for Lucknow property buyers, sellers, and investors.

STRICT RULES:
- The article MUST be about Lucknow only. If the original news is about another city, connect it to Lucknow specifically — what does it mean for Lucknow buyers?
- Write ONLY what you actually know from the news. Never repeat the same point twice in different words.
- Length is determined by the story — a small news item should be 150-200 words, a big story can be 400+ words. Never pad.
- Every sentence must add new information. If a sentence does not add anything new, cut it.
- Structure with <h3> headings only when the story genuinely has multiple distinct sections.
- Use simple everyday language. Write like a helpful friend, not a reporter.
- Explain technical terms (RERA, LDA, mutation, registry) briefly when first used.
- Include one practical takeaway for buyers/sellers/investors at the end.
- full_content must use ONLY: <p>, <h3>, <strong>, <ul>, <li> — no divs, no classes, no inline styles.
- Do NOT mention dsdproperties.in inside the article body.
{$langNote}

Category must be exactly one of: lda | it-city | price | projects | policy | rera

Return ONLY a raw JSON object. No markdown. No code fences. No explanation:

{
  "title": "Clear, specific headline about Lucknow. Under 90 characters.",
  "summary": "2-3 plain-text sentences. What happened and why it matters for Lucknow buyers.",
  "full_content": "Article in HTML. Length matches the story — no padding, no repetition.",
  "meta_description": "SEO description under 155 characters mentioning Lucknow.",
  "category": "policy"
}
SYSTEM;

        $userPrompt = <<<USER
Rewrite this news article for Lucknow real estate readers. Cover all the facts. Do not repeat any point. Do not pad. Write only what the story actually contains.

Source: {$item['source_name']}
Original Title: {$item['title']}
Summary: {$item['desc']}
URL: {$item['url']}
USER;

        $payload = json_encode([
            'model'       => self::GROQ_MODEL,
            'temperature' => 0.45,
            'max_tokens'  => 2000,
            'messages'    => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $userPrompt],
            ],
        ]);

        try {
            $ch = curl_init(self::GROQ_API_URL);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $payload,
                CURLOPT_TIMEOUT        => 45,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $apiKey,
                ],
            ]);

            $response  = curl_exec($ch);
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                $this->error('Groq cURL error: ' . $curlError);
                return null;
            }

            if ($httpCode !== 200) {
                $decoded = json_decode($response, true);
                $errMsg  = $decoded['error']['message'] ?? $response;
                $this->error("Groq HTTP {$httpCode}: " . Str::limit($errMsg, 200));
                Log::error('[AutoNewsService] Groq error', ['code' => $httpCode, 'body' => $response]);
                return null;
            }

            $data = json_decode($response, true);
            $text = $data['choices'][0]['message']['content'] ?? '';

            // Strip code fences
            $text = preg_replace('/```json\s*/i', '', $text);
            $text = preg_replace('/```\s*/',      '', $text);
            $text = trim($text);

            // Find JSON object boundaries
            $start = strpos($text, '{');
            $end   = strrpos($text, '}');
            if ($start === false || $end === false) {
                $this->warn('No JSON object found in Groq response.');
                return null;
            }
            $text = substr($text, $start, $end - $start + 1);

            // First try direct decode
            $parsed = json_decode($text, true);

            // If that fails, the HTML in full_content likely has unescaped chars.
            // Extract each field manually with regex as fallback.
            if (json_last_error() !== JSON_ERROR_NONE) {
                $parsed = $this->extractFieldsManually($text);
            }

            if (empty($parsed['title']) || empty($parsed['full_content'])) {
                $this->warn('Could not extract required fields from Groq response.');
                Log::warning('[AutoNewsService] Groq parse fail', ['raw' => Str::limit($text, 500)]);
                return null;
            }

            return $parsed;

        } catch (\Exception $e) {
            $this->error('Groq exception: ' . $e->getMessage());
            Log::error('[AutoNewsService] Groq exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    // ─────────────────────────────────────────────────────
    //  Helpers
    // ─────────────────────────────────────────────────────
    // Fallback: extract JSON fields manually when HTML in full_content breaks json_decode
    private function extractFieldsManually(string $text): array
    {
        $result = [];

        // Extract simple string fields
        foreach (['title', 'summary', 'meta_description', 'category'] as $field) {
            if (preg_match('/"' . $field . '"\s*:\s*"((?:[^"\\\\]|\\\\.)*)"/s', $text, $m)) {
                $result[$field] = stripslashes($m[1]);
            }
        }

        // Extract full_content — value between first <p> or <h3> and last closing tag
        if (preg_match('/"full_content"\s*:\s*"(.*?)"\s*(?:,\s*"[a-z]|\})/s', $text, $m)) {
            $result['full_content'] = stripslashes($m[1]);
        } else {
            // Wider grab: everything after "full_content": " until the last HTML closing tag
            if (preg_match('/"full_content"\s*:\s*"(.+)/s', $text, $m)) {
                $raw = $m[1];
                // Find last </p> or </ul> or </li>
                $lastTag = max(
                    strrpos($raw, '</p>'),
                    strrpos($raw, '</ul>'),
                    strrpos($raw, '</li>'),
                    strrpos($raw, '</h3>'),
                );
                if ($lastTag !== false) {
                    $result['full_content'] = stripslashes(substr($raw, 0, $lastTag + 4));
                }
            }
        }

        return $result;
    }

    private function normaliseCategory(string $cat): string
    {
        return isset(\App\Models\NewsArticle::CATEGORIES[$cat]) ? $cat : 'policy';
    }

    private function makeSlug(string $title): string
    {
        $slug     = Str::slug($title);
        $original = $slug;
        $count    = 1;
        while (NewsArticle::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }
        return $slug;
    }

    private function info(string $m): void    { $this->addLog('info',    $m); }
    private function success(string $m): void { $this->addLog('success', $m); }
    private function warn(string $m): void    { $this->addLog('warn',    $m); }
    private function error(string $m): void   { $this->addLog('error',   $m); }
    private function skip(string $m): void    { $this->addLog('skip',    $m); }

    private function addLog(string $type, string $message): void
    {
        $this->log[] = ['type' => $type, 'message' => $message, 'time' => now()->format('H:i:s')];
    }

    private function result(bool $success, int $saved): array
    {
        return ['success' => $success, 'saved' => $saved, 'log' => $this->log];
    }
}
