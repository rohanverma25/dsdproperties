<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One browser that agreed to receive new-message notifications.
 *
 * The endpoint is a long URL at the browser vendor's push service, so it is
 * stored as text and keyed by its hash — MySQL cannot make a TEXT column unique.
 */
class WaPushSubscription extends Model
{
    protected $fillable = [
        'endpoint', 'endpoint_hash', 'p256dh', 'auth', 'user_id', 'device', 'last_sent_at',
    ];

    protected $casts = ['last_sent_at' => 'datetime'];

    protected $hidden = ['endpoint', 'p256dh', 'auth'];

    public static function hashFor(string $endpoint): string
    {
        return hash('sha256', $endpoint);
    }

    /** Store (or refresh) a subscription the browser just handed us. */
    public static function remember(array $sub, ?int $userId, ?string $device): self
    {
        return static::updateOrCreate(
            ['endpoint_hash' => static::hashFor($sub['endpoint'])],
            [
                'endpoint' => $sub['endpoint'],
                'p256dh'   => $sub['keys']['p256dh'],
                'auth'     => $sub['keys']['auth'],
                'user_id'  => $userId,
                'device'   => $device ? mb_substr($device, 0, 255) : null,
            ]
        );
    }
}
