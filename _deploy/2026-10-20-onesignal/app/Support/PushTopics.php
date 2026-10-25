<?php

namespace App\Support;

use App\Models\NewsArticle;

/**
 * Works out which push topic a page or a story belongs to (see config/push.php).
 * Awas Vikas has no news category of its own, so its slug words win first.
 */
class PushTopics
{
    public static function all(): array
    {
        return config('push.topics', []);
    }

    public static function forNews(NewsArticle $article): ?string
    {
        return self::fromWords($article->slug, ['awas'])
            ?? self::fromNewsCategory($article->category);
    }

    /** $blog is a blog_posts row/model; only slug and tag are read. */
    public static function forBlog($blog): ?string
    {
        foreach (self::all() as $key => $topic) {
            if (in_array($blog->tag ?? null, $topic['blog_tags'], true)) {
                return $key;
            }
        }

        return self::fromWords($blog->slug ?? '');
    }

    /**
     * Page topic for the prompt: the story or post on the page, else words in the URL.
     * Only trusts $article / $blog on their own URLs — other views (the homepage) reuse those names.
     */
    public static function forView(array $data, string $path): ?string
    {
        $path = trim($path, '/');

        if (str_starts_with($path, 'news/') && ($data['article'] ?? null) instanceof NewsArticle) {
            return self::forNews($data['article']);
        }
        if (str_starts_with($path, 'blog/') && is_object($data['blog'] ?? null) && isset($data['blog']->slug)) {
            return self::forBlog($data['blog']);
        }

        return $path === '' ? null : self::fromWords($path);
    }

    public static function fromNewsCategory(?string $category): ?string
    {
        foreach (self::all() as $key => $topic) {
            if (in_array($category, $topic['news_categories'], true)) {
                return $key;
            }
        }

        return null;
    }

    private static function fromWords(string $text, ?array $only = null): ?string
    {
        $text = strtolower($text);

        foreach (self::all() as $key => $topic) {
            if ($only !== null && !in_array($key, $only, true)) {
                continue;
            }
            foreach ($topic['url_words'] as $word) {
                if (str_contains($text, $word)) {
                    return $key;
                }
            }
        }

        return null;
    }
}
