<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Response;

/**
 * /llms.txt — a plain-Markdown map of the site for AI assistants (llmstxt.org).
 *
 * The hand-written business part (services, prices, FAQ, contact) lives in
 * resources/llms/intro.md; the article list is built from the database so a
 * newly published post appears without an upload. Do not put a llms.txt in
 * public/ — the web server would serve it and this route would never run.
 */
class LlmsTxtController extends Controller
{
    public function __invoke(): Response
    {
        $posts = BlogPost::where('status', 'published')
            ->orderByRaw("CASE WHEN language = 'hi' THEN 1 ELSE 0 END")
            ->orderByDesc('updated_at')
            ->get(['title', 'slug', 'meta_description', 'tag', 'language']);

        $lines = [
            rtrim(file_get_contents(resource_path('llms/intro.md'))),
            '',
            '## More services and tools',
            '',
            '- [Property registry in Lucknow](' . url('/services/property-registry-lucknow') . '): registry and stamp duty assistance',
            '- [Property advisory in Lucknow](' . url('/services/property-advisory-lucknow') . '): buying and investment advice',
            '- [Stamp duty calculator](' . url('/tools/stamp-duty-calculator-lucknow') . '): stamp duty and registration charges in Lucknow',
            '- [Property listings](' . url('/properties') . '): reviewed properties for sale',
            '- [About DSD Properties](' . url('/about') . ')',
        ];

        foreach ($posts->groupBy(fn ($p) => $p->tag ?: 'Other guides') as $tag => $group) {
            $lines[] = '';
            $lines[] = '## Articles: ' . $tag;
            $lines[] = '';

            foreach ($group as $post) {
                $title = $this->clean($post->title) . ($post->language === 'hi' ? ' (Hindi)' : '');
                $desc  = $this->clean($post->meta_description);
                $lines[] = '- [' . $title . '](' . route('blog.show', $post->slug) . ')' . ($desc !== '' ? ': ' . $desc : '');
            }
        }

        return response(implode("\n", $lines) . "\n", 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /** One line, no Markdown link syntax that would break the list. */
    private function clean(?string $text): string
    {
        $text = html_entity_decode(strip_tags((string) $text), ENT_QUOTES, 'UTF-8');

        return trim(str_replace(['[', ']', "\n", "\r"], ['(', ')', ' ', ' '], preg_replace('/\s+/u', ' ', $text)));
    }
}
