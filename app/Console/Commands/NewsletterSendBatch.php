<?php

namespace App\Console\Commands;

use App\Models\NewsletterCampaign;
use App\Support\Newsletter;
use Illuminate\Console\Command;

/** Sends the next batch of every campaign that is going out. Scheduled hourly in Console\Kernel. */
class NewsletterSendBatch extends Command
{
    protected $signature = 'newsletter:send-batch {--limit= : emails per campaign this run (default: config newsletter.batch_size)}';

    protected $description = 'Send the next batch of the weekly newsletter';

    public function handle(): int
    {
        $campaigns = NewsletterCampaign::where('status', 'sending')->orderBy('id')->get();
        if ($campaigns->isEmpty()) {
            $this->line('No newsletter is being sent.');
            return self::SUCCESS;
        }
        foreach ($campaigns as $c) {
            [$sent, $failed, $left] = Newsletter::sendBatch($c, $this->option('limit') ? (int) $this->option('limit') : null);
            $this->info("{$c->week}: {$sent} sent, {$failed} failed, {$left} left");
        }
        return self::SUCCESS;
    }
}
