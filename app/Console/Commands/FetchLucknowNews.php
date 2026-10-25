<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoNewsService;

/**
 * php artisan news:fetch
 *
 * Searches Google (via Claude web_search) for today's Lucknow real estate
 * news from trusted portals, rewrites in simple human language, saves as
 * pending. Scheduled daily at 08:00 in app/Console/Kernel.php.
 */
class FetchLucknowNews extends Command
{
    protected $signature   = 'news:fetch';
    protected $description = 'Auto-fetch today\'s Lucknow real estate news, rewrite with Claude AI, save as pending';

    public function handle(): int
    {
        $this->info('');
        $this->info('═══════════════════════════════════════════');
        $this->info('  DSD Properties — Daily News Fetch');
        $this->info('  ' . now()->format('D, d M Y · H:i'));
        $this->info('═══════════════════════════════════════════');
        $this->info('');

        $service = new AutoNewsService();
        $result  = $service->run();

        foreach ($result['log'] as $entry) {
            $msg = '[' . $entry['time'] . '] ' . $entry['message'];

            match ($entry['type']) {
                'success' => $this->info('  ✓ ' . $msg),
                'warn'    => $this->warn('  ⚠ ' . $msg),
                'error'   => $this->error('  ✗ ' . $msg),
                'skip'    => $this->line('  ⏭ ' . $msg),
                default   => $this->line('  · ' . $msg),
            };
        }

        $this->info('');

        if ($result['success']) {
            $this->info('  ✅ ' . $result['saved'] . ' article(s) saved. Review at /admin/news');
            return Command::SUCCESS;
        }

        $this->warn('  ⚠ Completed with 0 articles saved. Check logs above.');
        return Command::FAILURE;
    }
}
