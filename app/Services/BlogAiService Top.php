<?php 
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
set_time_limit(500);

class BlogAiService
{
    protected string $endpoint = 'https://api.openai.com/v1/chat/completions';
    protected string $siteName = "DSD Properties";
    public function __construct(
        protected string $model = '',
        protected int $timeout = 500,
    ) {
        $this->model = $this->model ?: config('services.openai.model');
        $this->timeout = $this->timeout ?: (int) config('services.openai.timeout');
    }

    public function generateMeta(string $topic, array $keywords = []): array
    {
    $system = 'You are an SEO content strategist.
    - Generate metadata and schema for a real estate blog.
    - Return strict JSON with keys: {title, slug, description, meta_keywords, tags, language}.
    - Title: ≤60 chars, catchy, keyword-rich.
    - Title Case (capitalize each word).
    - Title should include the location "Lucknow" if relevant.
    - Title should be eyecatching for Lucknow property buyers.
    - Description: 150–160 chars, natural, no "Keywords:" prefix.
    - Slug: URL-friendly, lowercase, hyphen-separated, ≤100 chars.
    - Meta Description: 150–160 chars, natural, no "Keywords:" prefix.
    - Meta Keywords: 4–8 relevant, comma-separated phrases (search-intent, location-based if needed).
    - Tags: 4–8 comma-separated words/phrases.
    - Language: match the topic (English or Hindi). Return key "language" with "en" or "hi".
    - Focus on Lucknow property, houses, apartments, landmarks, lifestyle, or real estate visuals.
    - Do NOT include any explanation or text outside the JSON. Only return valid JSON with these keys.';

        $user = "Topic: {$topic}\n"
            . "Keywords to include (if possible): " . implode(', ', $keywords) . "\n"
            . "Website name: {$this->siteName}";

        $raw = $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $user],
        ], ['temperature' => 0.6], 'gpt-4o-mini');

        $json = json_decode($raw, true);
        if (!is_array($json)) {
            $json = json_decode($this->extractJson($raw), true) ?: [];
        }

        return [
            'title'        => $json['title'] ?? Str::limit($topic, 100, ''),
            'description'  => $json['description'] ?? Str::limit("Learn about {$topic} in Lucknow real estate.", 160, ''),
            'tags'         => $json['tags'] ?? implode(', ', $keywords),
            'meta_keywords'=> $json['meta_keywords'] ?? implode(', ', $keywords),
            'slug'         => $json['slug'] ?? Str::slug(Str::limit($topic, 100, '')),
            'language'     => $json['language'] ?? 'en',
        ];
    }

    // public function generateImageQuery(string $blogTitle, $blogDescription, $blogTags): string
    // {
    //     $prompt = "Generate a short, SEO-friendly Unsplash image search query (max 5 words) 
    //     relevant to the blog content below. Avoid brand names and people. 
    //     Return the response strictly as a valid JSON object with a single key 'image_query'. 
    //     Do not include explanations or extra text. 

    //     Example: {\"image_query\": \"modern house exterior\"}

    //     Blog Title: {$blogTitle} 
    //     Blog Description: {$blogDescription} 
    //     Blog Tags: {$blogTags}";

    //     $raw = $this->chat([
    //         ['role' => 'system', 'content' => 'You are an assistant that generates high-quality Unsplash search queries for blog post images.  
    // The goal is to get **illustration-style images** that are relevant, visually appealing, and aligned with the blog topic.'],
    //         ['role' => 'user', 'content' => $prompt],
    //     ], ['temperature' => 0.6]);

    //     $json = json_decode($raw, true);
    //     if (!is_array($json)) { 
    //         $json = json_decode($this->extractJson($raw), true) ?: [];
    //     }
    //     return $json['image_query'] ?? 'Real Estate Image';
    // }

    function cleanResponse(string $text): string
    {
        $text = preg_replace('/\*\*[[:punct:]\s]*\*\*/', '', $text);

        $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);

        $text = preg_replace('/\s+/', ' ', $text);

        $text = trim($text);

        return $text;
    }

    protected function chat(array $messages, array $extra = [], string $model): string
    {
        $payload = array_merge([
            'model' => $model,
            'messages' => $messages,
            'temperature' => 0.6,
        ], $extra);

        $response = Http::withToken(config('services.openai.key'))
            ->timeout($this->timeout)
            ->retry(2, 500)
            ->post($this->endpoint, $payload);

        if (!$response->successful()) {
            throw new \RuntimeException('OpenAI error: '.$response->status().' '.$response->body());
        }

        $raw = data_get($response->json(), 'choices.0.message.content', '');

        return $this->cleanResponse($raw);
    }

    /**
     * Generate a concise JSON outline: ["H1 title", "H2...", "H2..."]
     */
    public function generateOutline(string $topic): array
    {
        $system = 'You are an SEO content strategist. Return ONLY valid JSON array of section titles. No prose.';
        $user = "Create an outline for a 800–1500 word blog on: {$topic}. Include 4–6 H2-level section titles. Keep titles concise.";

        $raw = $this->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $user],
        ], ['temperature' => 0.6], 'gpt-4o-mini');

        $json = json_decode($raw, true);
        if (!is_array($json)) {
            // fallback: try to extract JSON
            $json = json_decode($this->extractJson($raw), true) ?: [];
        }
        return array_values(array_filter($json));
    }

    /**
     * Generate one section in HTML (no full article, just this section content)
     */
  public function generateSection(string $topic, string $sectionTitle, array $contextOutline = []): string
{
    $system = 'You are an **SEO expert property blog copywriter**.  
    - Write **SEO-optimized section content** in either **English or Hindi**.  
    - Ensure the article is plagiarism-free, factual, simple english and accurate.
    - Use <h2>, <h3>, <<h4>, <h5>, <h6>, <div>, <span>, <strong>, <em>, <p>, <ul>, <ol>, <a>, <table>, <thead>, <tbody>, <i>.  
    - Conversational tone for Lucknow buyers.  
    - Insert colors #011f4b color for main heading and #008080 for sub headings strictly. 
    - If something is very important, use #FF5C00 color.
    - Use bullet points or numbered lists for clarity.  
    - All the headings must have class (e.g. <h2 class="section-title" id="section-name">).
    - All the referral links must have class (e.g. <a class="referral-link" href="...">).
    - Use <strong> or <i> for important highlights.  
    - Use title case for headings (capitalize each word).
    - If table for comparisons, differences, or structured data are relevant (like buy vs. rent, pros vs. cons, property registration charges, stamp duty rates, circle rates, property price ranges, loan eligibility, EMI breakdowns, facilities comparison, location-wise advantages, amenities lists, government charges/fees, or property type differences), present them in a clean HTML <table> with proper headings and rows for better readability.
    - Add **as much data as possible** data in table (minimum 10–50 rows), more if relevant.
    - Ensure the table is **accurate, factual, and complete**.  
    - Keep section self-contained (250–300 words). 
    - Provide detailed information with facts If possible.
    - add ids in the paragraphs if required.
    - Do NOT add FAQs, meta, or TOC here (only in final blog).';
    $outlineText = implode("\n", array_map('strval', $contextOutline));

    $user = trim(<<<TXT
        Topic: {$topic}  
        Section to write: {$sectionTitle}  
        Outline context (other sections):  
        - """\n{$outlineText}\n"""  
        Requirements:  
        - Write only the section content (250–300 words).  
        - Do not include FAQs or metadata.  
    TXT);

    return $this->chat([
        ['role' => 'system', 'content' => $system],
        ['role' => 'user', 'content' => $user],
    ], [
        'temperature' => 0.7,
    ], 'gpt-4o');
}

//     public function generateFaq(string $topic): array
// {
//     $system = 'You are an SEO content strategist. Return strict JSON: [{question: string, answer: string}, ...]';
//     $user = "Generate 4–6 frequently asked questions and answers for a blog on '{$topic}'. 
//     Keep answers concise (50–80 words). Use natural language, not robotic.";

//     $raw = $this->chat([
//         ['role' => 'system', 'content' => $system],
//         ['role' => 'user', 'content' => $user],
//     ], ['temperature' => 0.6]);

//     $json = json_decode($raw, true);
//     if (!is_array($json)) {
//         $json = json_decode($this->extractJson($raw), true) ?: [];
//     }
//     return $json;
// }

    /** Combine sections into one HTML article */
public function assembleArticle(string $topic, array $sections, $relatedBlogs): string
{
 $links = $relatedBlogs->isEmpty()
    ? "⚠️ No related blogs found."
    : $relatedBlogs->map(fn($b) => "- {$b->title} ({$b->slug})")->implode("\n");

    $system = <<<PROMPT
You are an **SEO property blog compiler**.
- Generate a 800-1600 words blog article in HTML format.
- Use proper headings (H2, H3).
- Naturally insert 3–5 contextual internal links using the following related blogs:
$links

Rules for linking:
- Only link if the context matches.
- Use natural anchor text (rephrase if needed).
- Insert inline inside paragraphs or after paragraphs, not as a separate list.
- Do not force all links; skip if not relevant.
- Do NOT link the same blog multiple times.
- Do not add more than 3 internal links in the entire article.
- Use <a href="/blog/{slug}">Title</a> format.
- **External links (if required) must only be to official government websites** such as:
  - UP Government portal: https://up.gov.in
  - Bhulekh UP (Land Records): https://upbhulekh.gov.in
  - UPEIDA (Expressways): https://upeida.up.gov.in
  - Invest UP: https://invest.up.gov.in
  - RERA Uttar Pradesh: https://up-rera.in
  - UP PWD: https://uppwd.gov.in
  - UP Police: https://uppolice.gov.in
  - UPSDMA (Disaster Mgmt): https://upsdma.up.nic.in
  - Any other valid *.gov.in, *.nic.in, or official UP state portals.
- Write in either English or Hindi based on the topic.

- Combine all sections into a single article.  
- provide deep, comprehensive coverage of the topic.
- Add a **Table of Contents** with anchor links (use <a href="#id">) with required <ul> <li> after first section not at the top of the blog, heading will be "Table of Contents" and its id will be "toc_id".  
- Do not add any color into <table> <thead> <tbody> also table should be in <table> <thead> <tbody> format always.
- Add a catchy **introduction** (50–80 words) at the start.   
- If comparisons, differences, or structured data are relevant (like buy vs. rent, pros vs. cons, property registration charges, stamp duty rates, circle rates, property price ranges, loan eligibility, EMI breakdowns, facilities comparison, location-wise advantages, amenities lists, government charges/fees, or property type differences), present them in a clean HTML <table> with proper headings and rows for better readability.
- Add ids to headings for TOC links (e.g. <h2 id="section-title">).
- Add ids in the paragraphs if required.
- Use a conversational tone for Lucknow property buyers.
- For headings use title case (capitalize each word).
- For important highlights, use **bold** or *italics* bold should be in <strong> and italic in the <i>.
- Use bullet points or numbered lists for clarity.
- For Heading use "Title Case" (capitalize each word).
- For headings use class (e.g. <h2 class="section-title">).
- For heading use only #008080 and #011f4b color strictly.
- Ensure each section flows naturally to the next.
- Append FAQs (5–7 with answers).
- Do not add any css into FAQs section and It should be <ol class="faq-ol-class"> <li class="faq-li-class"> format.
- Ensure easy English (or Hindi if specified).
- Ensure the article is plagiarism-free, factual, and accurate.
- Do not add more than 3 tables in the entire article.
- Add ids in the headings for each section (e.g. <h2 id="section-introduction">).
PROMPT;
    $user = "Topic: {$topic}\n\nBlog sections:\n" . implode("\n\n", $sections);

    return $this->chat([
        ['role' => 'system', 'content' => $system],
        ['role' => 'user', 'content' => $user],
    ], [
        'temperature' => 0.6,
    ], 'gpt-4o');
}

    /** Utility: try to extract first JSON block from a string */
    protected function extractJson(string $text): string
    {
        if (preg_match('/\[.*\]|\{.*\}/s', $text, $m)) {
            return $m[0];
        }
        return '[]';
    }
}
?>