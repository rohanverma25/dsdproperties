<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * Generate the one VAPID key pair browser notifications need.
 *
 * The keys are made in the gateway, because that is where notifications are
 * signed — PHP would need ext-gmp for the same maths. Run once per install:
 * changing the pair later invalidates every subscription, so everyone has to
 * turn notifications back on.
 */
class WhatsAppVapidKeys extends Command
{
    protected $signature = 'whatsapp:vapid {--force : Print a new pair even though one is already configured}';

    protected $description = 'Generate the VAPID key pair for WhatsApp browser notifications';

    public function handle(): int
    {
        if (config('whatsapp.vapid.public_key') && ! $this->option('force')) {
            $this->warn('A VAPID key pair is already configured.');
            $this->line('Replacing it logs every device out of notifications. Use --force if that is what you want.');

            return self::SUCCESS;
        }

        $service = base_path('whatsapp-service');

        if (! is_dir($service . '/node_modules/web-push')) {
            $this->error('The gateway dependencies are not installed.');
            $this->line('Run this first:  cd whatsapp-service && npm install');

            return self::FAILURE;
        }

        $process = new Process(
            ['node', '-e', 'const w=require("web-push");const k=w.generateVAPIDKeys();console.log(k.publicKey);console.log(k.privateKey);'],
            $service
        );
        $process->run();

        if (! $process->isSuccessful()) {
            $this->error('Could not generate the keys.');
            $this->line(trim($process->getErrorOutput()) ?: 'Is node on the PATH?');

            return self::FAILURE;
        }

        [$public, $private] = array_pad(array_filter(explode("\n", str_replace("\r", '', trim($process->getOutput())))), 2, '');

        if (! $public || ! $private) {
            $this->error('The gateway returned an unexpected key pair.');

            return self::FAILURE;
        }

        $this->info('Add these to .env:');
        $this->line('');
        $this->line('WHATSAPP_VAPID_SUBJECT=mailto:you@example.com');
        $this->line('WHATSAPP_VAPID_PUBLIC_KEY=' . $public);
        $this->line('');
        $this->info('…and the same pair to whatsapp-service/.env, which does the signing:');
        $this->line('');
        $this->line('WA_VAPID_SUBJECT=mailto:you@example.com');
        $this->line('WA_VAPID_PUBLIC_KEY=' . $public);
        $this->line('WA_VAPID_PRIVATE_KEY=' . $private);
        $this->line('');
        $this->comment('Then run `php artisan config:clear` and restart the gateway.');
        $this->comment('The private key stays with the gateway — Laravel never needs it.');

        return self::SUCCESS;
    }
}
