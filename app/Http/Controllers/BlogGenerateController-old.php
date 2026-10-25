<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\BlogAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
set_time_limit(500);
class BlogGenerateController extends Controller
{
    public function generate(Request $request, BlogAiService $ai)
    {
        // $validated = $request->validate([
        //     'topic' => 'required|string|min:6',
        //     'keywords' => 'nullable|string', // comma-separated
        // ]);
        $topic = $request->input('topic', 'rent vs buy in hindi'); // fallback if no input
        $keywords = $request->input('tags', array('Real Estate', 'Lucknow')); // fallback if no input
        //$topic = trim($validated['topic']);
        //$keywords = array_values(array_filter(array_map('trim', explode(',', (string)($validated['keywords'] ?? '')))));
        $topic = trim($topic);
        $keywords = array_values(array_filter(array_map('trim', explode(',', (string)("real estate, property" ?? '')))));
        // Step 1: Outline
        $outline = $ai->generateOutline($topic);
        // Step 3: Meta + Assemble
        $meta = $ai->generateMeta($topic, $keywords);
        $generateImageQuery = $ai->generateImageQuery($meta['title'], $meta['description'], $meta['tags']);
        $imageData = $this->fetchUnsplashImage($generateImageQuery);
        if ($imageData) {
            $meta['image_source'] = $imageData['url'];
            $meta['alt'] = $imageData['alt'];
        }

        $relatedTags = $meta['tags'] ? array_map('trim', explode(',', $meta['tags'])) : [];
        $relatedBlogs = $this->relatedBlogs($relatedTags, $meta['language'] ?? 'en') ?? [];
        if (empty($outline)) {
            return response()->json(['message' => 'Failed to generate outline'], 422);
        }
        // print_r($meta);
        // exit;
        // Step 2: Sections (sequential to avoid timeouts)
        $sections = [];
        foreach ($outline as $title) {
            $sections[] = $ai->generateSection($topic, $title, $outline);
        }

        $contentHtml = $ai->assembleArticle($topic, $sections, $relatedBlogs);
        if (empty($contentHtml)) {
            return response()->json(['message' => 'Failed to generate content'], 422);
        }

        // Save draft
        $post = BlogPost::create([
            'title' => $meta['title'] ?? $topic,
            'slug' => $meta['slug'].'-'.Str::random(5),
            'meta_description' => $meta['description'] ?? null,
            'meta_keywords'=> $meta['meta_keywords'] ?? null,
            'tags' => $meta['tags'] ?? [],
            'outline' => $outline,
            'content_html' => $contentHtml,
            'featured_image' => $meta['image_source'] ?? null,
            'alt' => $meta['alt'] ?? 'en',
            'status' => 'draft',
            'language' => $meta['language'] ?? 'en',
            'author_id' => rand(1, 10),
        ]);

        return response()->json([
            'message' => 'Draft created successfully',
            'post_id' => $post->id,
            'slug' => $post->slug,
        ]);
    }

    function relatedBlogs(array $keywords, string $language = 'en')
    {
        return BlogPost::where('status', 'draft')
            ->where('language', $language)  
            ->select('title','slug','tags')
            ->selectRaw("(" . implode(" + ", array_map(function($kw) {
                return "CASE WHEN tags LIKE '%" . addslashes($kw) . "%' THEN 1 ELSE 0 END";
            }, $keywords)) . ") as match_score")
            ->orderByDesc('match_score')
            ->take(10)
            ->get();
    }

   public function fetchUnsplashImage($query)
{
    $accessKey = "yoy11B_-quzNKVM-SAFLYHzymkpaHWLlVHMezUL1Chc";
    if (!$accessKey) {
        return null;
    }
    $url = "https://api.unsplash.com/photos/random?" . http_build_query([
        'query'          => $query,
        'orientation'    => 'landscape',     // or portrait, squarish
        'content_filter' => 'high',          // safer images
        'count'          => 1,               // you can request multiple
        'topics'       => 'Real Estate',  // optional: restrict to a topic
    ]) . "&client_id=" . $accessKey;

    try {
        $response = file_get_contents($url);
        if ($response === FALSE) {
            return null;
        }

        $data = json_decode($response, true);
        if (isset($data[0]['urls']['regular'])) { // if count > 1, response is array
            return [
                'url' => $data[0]['urls']['regular'],
                'alt' => $data[0]['alt_description'] ?? 'Image related to ' . $query,
            ];
        } elseif (isset($data['urls']['regular'])) { // if count = 1, response is object
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
