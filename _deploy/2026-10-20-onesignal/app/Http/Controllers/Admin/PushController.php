<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\SitePushSend;
use App\Models\SitePushSubscriber;
use App\Services\OneSignalPush;
use App\Support\PushTopics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * /admin/push — send a website notification about a news story or article,
 * to everyone, to one topic, or to a single browser as a test.
 */
class PushController extends Controller
{
    public function __construct(protected OneSignalPush $push)
    {
    }

    public function index()
    {
        $topics = PushTopics::all();

        $news = NewsArticle::published()->latest()->limit(15)->get()->map(fn ($a) => [
            'label'   => 'News · ' . $a->title,
            'title'   => Str::limit($a->title, 60, '…'),
            'message' => Str::limit((string) $a->summary, 140, '…'),
            'url'     => url('/news/' . $a->slug),
            'image'   => '',
            'topic'   => PushTopics::forNews($a) ?? '',
        ]);

        $posts = DB::table('blog_posts')->where('status', 'published')
            ->orderByDesc('created_at')->limit(15)
            ->get(['title', 'slug', 'tag', 'meta_description', 'featured_image'])
            ->map(fn ($b) => [
                'label'   => 'Article · ' . $b->title,
                'title'   => Str::limit($b->title, 60, '…'),
                'message' => Str::limit((string) $b->meta_description, 140, '…'),
                'url'     => url('/blog/' . $b->slug),
                'image'   => $b->featured_image ? $this->absolute($b->featured_image) : '',
                'topic'   => PushTopics::forBlog($b) ?? '',
            ]);

        $topicCounts = [];
        foreach (array_keys($topics) as $key) {
            $topicCounts[$key] = SitePushSubscriber::whereRaw('FIND_IN_SET(?, topics)', [$key])->count();
        }

        return view('admin.push.index', [
            'configured'  => $this->push->configured(),
            'topics'      => $topics,
            'content'     => $news->concat($posts)->values(),
            'total'       => SitePushSubscriber::count(),
            'topicCounts' => $topicCounts,
            'bySource'    => SitePushSubscriber::select('source_path', DB::raw('count(*) as c'))
                                ->groupBy('source_path')->orderByDesc('c')->limit(10)->get(),
            'recentSubs'  => SitePushSubscriber::latest()->limit(8)->get(),
            'sends'       => SitePushSend::latest()->limit(20)->get(),
        ]);
    }

    public function send(Request $request)
    {
        $topicKeys = array_keys(PushTopics::all());

        $data = $request->validate([
            'title'    => ['required', 'string', 'max:80'],
            'message'  => ['required', 'string', 'max:200'],
            'url'      => ['required', 'url', 'max:400'],
            'image'    => ['nullable', 'url', 'max:400'],
            'audience' => ['required', 'string', 'in:all,test,' . implode(',', array_map(fn ($k) => 'topic:' . $k, $topicKeys))],
            'test_id'  => ['required_if:audience,test', 'nullable', 'string', 'max:64', 'regex:/^[A-Za-z0-9-]+$/'],
        ]);

        if (!$this->push->configured()) {
            return back()->withInput()->with('error', 'OneSignal is not set up: add ONESIGNAL_APP_ID and ONESIGNAL_REST_API_KEY to .env.');
        }

        $audience = $data['audience'] === 'test' ? 'test:' . $data['test_id'] : $data['audience'];
        $url      = $this->withUtm($data['url']);

        $result = $this->push->send($data['title'], $data['message'], $url, $audience, $data['image'] ?? null);

        SitePushSend::create([
            'title'        => $data['title'],
            'message'      => $data['message'],
            'url'          => $url,
            'image'        => $data['image'] ?? null,
            'audience'     => $audience,
            'onesignal_id' => $result['id'],
            'status'       => $result['status'],
            'error'        => $result['error'],
        ]);

        return match ($result['status']) {
            'sent'          => back()->with('success', 'Notification sent.'),
            'no_recipients' => back()->withInput()->with('info', 'Sent to OneSignal, but nobody matched this audience yet.' . ($result['error'] ? ' ' . $result['error'] : '')),
            default         => back()->withInput()->with('error', 'OneSignal refused it: ' . $result['error']),
        };
    }

    /** utm_source=onesignal so GA4 shows visits and leads that came from a notification. */
    private function withUtm(string $url): string
    {
        $parts = parse_url($url);
        parse_str($parts['query'] ?? '', $query);

        $query += [
            'utm_source'   => 'onesignal',
            'utm_medium'   => 'push',
            'utm_campaign' => Str::limit(basename($parts['path'] ?? 'home'), 60, ''),
        ];

        return strtok($url, '?#') . '?' . http_build_query($query);
    }

    private function absolute(string $path): string
    {
        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset(ltrim($path, '/'));
    }
}
