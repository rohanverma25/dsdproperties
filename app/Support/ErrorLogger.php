<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Keeps one row per distinct production error in app_error_logs (see the 2026_10_26 migration), so errors can be
 * reviewed from the database. Stores only the exception class, message, file:line, method and URL path — never
 * request input, headers or user data. It must never throw: a broken log must not break the page.
 */
class ErrorLogger
{
    public static function record(Throwable $e): void
    {
        try {
            $file = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $e->getFile());
            $message = mb_substr(preg_replace('/\s+/', ' ', $e->getMessage()), 0, 2000);
            // Numbers and quoted values vary between occurrences of the same bug; drop them from the grouping key
            $key = get_class($e) . '|' . $file . '|' . $e->getLine() . '|' . preg_replace(["/'[^']*'/", '/\d+/'], ["''", '0'], $message);
            $hash = sha1($key);
            $req = app()->runningInConsole() ? null : request();
            $now = now();
            $updated = DB::table('app_error_logs')->where('hash', $hash)->update([
                'count' => DB::raw('count + 1'), 'last_seen' => $now,
                'url' => $req ? mb_substr($req->path(), 0, 500) : 'console', 'message' => $message,
            ]);
            if (!$updated) {
                DB::table('app_error_logs')->insertOrIgnore([
                    'hash' => $hash, 'exception' => mb_substr(get_class($e), 0, 191), 'message' => $message,
                    'file' => mb_substr($file, 0, 255), 'line' => $e->getLine(),
                    'method' => $req?->method(), 'url' => $req ? mb_substr($req->path(), 0, 500) : 'console',
                    'count' => 1, 'first_seen' => $now, 'last_seen' => $now,
                ]);
            }
        } catch (Throwable) {
            // the table may not exist yet, or the database itself is the problem: the normal log still has it
        }
    }
}
