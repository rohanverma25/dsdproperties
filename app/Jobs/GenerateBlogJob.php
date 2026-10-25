<?php

namespace App\Jobs;

use App\Models\BlogPost;
use App\Services\BlogAiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateBlogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $topic;
    protected array $keywords;

    /**
     * Create a new job instance.
     */
    public function __construct(string $topic, array $keywords = [])
    {
        $this->topic = $topic;
        $this->keywords = $keywords;
    }

    /**
     * Execute the job.
     */
    public function handle(BlogAiService $ai): void
    {
        $topic = trim($this->topic);
        $keywords = $this->keywords ?: ['Real Estate', 'Property'];

        // Step 1: Outline
        $outline = $ai->generateOutline($topic);
        if (empty($outline)) {
            return; // bail out
        }

        // Step 2: Meta
        $meta = $ai->generateMeta($topic, $keywords);
        $generateImageQuery = $ai->generateImageQuery($meta['title'], $meta['description'], $meta['tags']);
        $imageData = $this->fetchUnsplashImage($generateImageQuery);

        if ($imageData) {
            $meta['image_source'] = $imageData['url'];
            $meta['alt'] = $imageData['alt'];
        }

        // Related Blogs
        $relatedTags = $meta['tags'] ? array_map('trim', explode(',', $meta['tags'])) : [];
        $relatedBlogs = BlogPost::where('status', 'draft')
            ->where('language', $meta['language'] ?? 'en')
            ->take(10)
            ->get();

        // Step 3: Sections
        $sections = [];
        foreach ($outline as $title) {
            $sections[] = $ai->generateSection($topic, $title, $outline);
        }

        $contentHtml = $ai->assembleArticle($topic, $sections, $relatedBlogs);

        if (empty($contentHtml)) {
            return;
        }

        // Save Draft
        BlogPost::create([
            'title'           => $meta['title'] ?? $topic,
            'slug'            => $meta['slug'].'-'.Str::random(5),
            'meta_description'=> $meta['description'] ?? null,
            'meta_keywords'   => $meta['meta_keywords'] ?? null,
            'tags'            => $meta['tags'] ?? [],
            'outline'         => $outline,
            'content_html'    => $contentHtml,
            'featured_image'  => $meta['image_source'] ?? null,
            'alt'             => $meta['alt'] ?? 'en',
            'status'          => 'draft',
            'language'        => $meta['language'] ?? 'en',
            'author_id'       => rand(1, 10),
        ]);
    }

    private function fetchUnsplashImage($query)
    {
        $accessKey = "yoy11B_-quzNKVM-SAFLYHzymkpaHWLlVHMezUL1Chc";
        if (!$accessKey) {
            return null;
        }

        $url = "https://api.unsplash.com/photos/random?" . http_build_query([
            'query'          => $query,
            'orientation'    => 'landscape',
            'content_filter' => 'high',
            'count'          => 1,
            'topics'         => 'Real Estate',
        ]) . "&client_id=" . $accessKey;

        try {
            $response = file_get_contents($url);
            if ($response === FALSE) {
                return null;
            }

            $data = json_decode($response, true);
            if (isset($data[0]['urls']['regular'])) {
                return [
                    'url' => $data[0]['urls']['regular'],
                    'alt' => $data[0]['alt_description'] ?? 'Image related to ' . $query,
                ];
            } elseif (isset($data['urls']['regular'])) {
                return [
                    'url' => $data['urls']['regular'],
                    'alt' => $data['alt_description'] ?? 'Image related to ' . $query,
                ];
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}
