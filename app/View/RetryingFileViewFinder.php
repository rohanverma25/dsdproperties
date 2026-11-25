<?php

namespace App\View;

use Illuminate\Support\Facades\File;
use Illuminate\View\FileViewFinder;
use InvalidArgumentException;

/**
 * hPanel Git Deploy rewrites the whole checkout on every push, and for ~10–30 s Blade files can be missing,
 * even ones the push didn't change. Pages then failed with "View [x] not found" (app_error_logs, Oct–Nov 2026;
 * a 15 s retry was still too short on 26 Nov).
 *
 * Fix (26 Nov 2026): when an app view is missing, it is served from a mirror copy of resources/views kept in storage/ (which
 * the deploy doesn't touch). The mirror is refreshed by /run-route-cache (self::syncMirror()). A view that is
 * in neither place still fails, after a short retry. Namespaced views (errors::404, mail::…) are left alone,
 * because Laravel probes those with view()->exists() while rendering error pages.
 */
class RetryingFileViewFinder extends FileViewFinder
{
    private const TRIES = 4;        // 4 x 250 ms, only when the mirror doesn't have the view either
    private const WAIT_US = 250000;

    public static function mirrorPath(): string
    {
        return storage_path('app/views-mirror');
    }

    /** Copy resources/views into the mirror. Returns the number of files copied. */
    public static function syncMirror(): int
    {
        $src = resource_path('views');
        if (! is_dir($src) || ! file_exists($src . '/layouts/user-app.blade.php')) {
            return 0; // checkout looks incomplete (deploy running); keep the old mirror
        }
        // Build a fresh copy next to the mirror, then swap it in, so views deleted from the repo leave the mirror too.
        $tmp = self::mirrorPath() . '.new';
        File::deleteDirectory($tmp);
        if (! File::copyDirectory($src, $tmp)) {
            return 0;
        }
        File::deleteDirectory(self::mirrorPath());
        File::moveDirectory($tmp, self::mirrorPath());

        return count(File::allFiles(self::mirrorPath()));
    }

    public function find($name)
    {
        if ($this->hasHintInformation($name = trim($name))) {
            return parent::find($name);
        }

        for ($try = 1; ; $try++) {
            try {
                return parent::find($name);
            } catch (InvalidArgumentException $e) {
                if ($path = $this->findInMirror($name)) {
                    return $path;
                }
                if ($try >= self::TRIES) {
                    throw $e;
                }
                usleep(self::WAIT_US);
                clearstatcache();
            }
        }
    }

    private function findInMirror(string $name): ?string
    {
        $base = self::mirrorPath();
        foreach ($this->getPossibleViewFiles($name) as $file) {
            if (is_file($path = $base . '/' . $file)) {
                return $path;
            }
        }

        return null;
    }
}
