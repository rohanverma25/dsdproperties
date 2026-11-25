<?php

namespace App\View;

use Illuminate\View\FileViewFinder;
use InvalidArgumentException;

/**
 * hPanel Git Deploy replaces files one by one, so for up to ~10 seconds after each push (even views the push didn't change) a Blade file can be missing
 * and the page fails with "View [x] not found" (seen after every deploy in app_error_logs, Oct–Nov 2026).
 * When an app view is not found, wait briefly and look again before giving up. A view that really doesn't
 * exist still fails, about 15 s later. Namespaced views (errors::404, mail::…) are not retried, because Laravel
 * probes those with view()->exists() while rendering error pages.
 */
class RetryingFileViewFinder extends FileViewFinder
{
    private const TRIES = 60;   // 60 x 250 ms = 15 s: a deploy rewrites the whole checkout for ~10 s (26 Nov 2026)
    private const WAIT_US = 250000;

    public function find($name)
    {
        if ($this->hasHintInformation($name = trim($name))) {
            return parent::find($name);
        }

        for ($try = 1; ; $try++) {
            try {
                return parent::find($name);
            } catch (InvalidArgumentException $e) {
                if ($try >= self::TRIES) {
                    throw $e;
                }
                usleep(self::WAIT_US);
                clearstatcache();
            }
        }
    }
}
