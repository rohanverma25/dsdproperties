<?php

namespace App\Http\Controllers;

use App\Models\SitePushSubscriber;
use Illuminate\Http\Request;

/**
 * Called by partials/onesignal.blade.php right after a visitor allows notifications,
 * so /admin/push can show which pages bring subscribers. OneSignal holds the real list.
 */
class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $topicKeys = array_keys(config('push.topics', []));

        $data = $request->validate([
            'subscription_id' => ['required', 'string', 'max:64', 'regex:/^[A-Za-z0-9-]+$/'],
            'topics'          => ['nullable', 'array', 'max:10'],
            'topics.*'        => ['string', 'in:' . implode(',', $topicKeys)],
            'page_topic'      => ['nullable', 'string', 'in:' . implode(',', $topicKeys)],
            'path'            => ['nullable', 'string', 'max:255'],
        ]);

        $path = '/' . ltrim($data['path'] ?? '/', '/');

        $existing = SitePushSubscriber::where('subscription_id', $data['subscription_id'])->first();

        SitePushSubscriber::updateOrCreate(
            ['subscription_id' => $data['subscription_id']],
            [
                'topics'      => implode(',', array_unique($data['topics'] ?? [])) ?: null,
                // Keep the page they first subscribed on; later calls only refresh topics.
                'page_topic'  => $existing->page_topic ?? ($data['page_topic'] ?? null),
                'source_path' => $existing->source_path ?? $path,
                'source_type' => $existing->source_type ?? $this->typeOf($path),
            ]
        );

        return response()->json(['ok' => true]);
    }

    private function typeOf(string $path): string
    {
        return match (true) {
            str_starts_with($path, '/news')        => 'news',
            str_starts_with($path, '/blog')        => 'blog',
            str_starts_with($path, '/lda-schemes') => 'scheme',
            default                                => 'page',
        };
    }
}
