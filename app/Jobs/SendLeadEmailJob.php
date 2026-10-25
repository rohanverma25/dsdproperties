<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\EmailTemplate;
use App\Mail\ColdEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLeadEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lead;
    public $templateId;

    public function __construct(Lead $lead, int $templateId)
    {
        $this->lead = $lead;
        $this->templateId = $templateId;
    }

    public function handle()
    {
        $template = EmailTemplate::find($this->templateId);

        if (!$template) {
            return;
        }

        try {
            // Mail::to($this->lead->email)
            // ->bcc([
            //     'dheer725@gmail.com',
            // ])
            // ->send(new ColdEmail($this->lead, $template));

            // Send email (no BCC for now)
            Mail::to($this->lead->email)
                ->send(new ColdEmail($this->lead, $template));

            // ✅ Update only if email sent successfully
            $this->lead->update([
                'is_email_sent' => 1,
                'last_emailed_at' => now()
            ]);

        } catch (\Exception $e) {
            \Log::error('Cold email failed for lead ID: ' . $this->lead->id, [
                'email' => $this->lead->email,
                'error' => $e->getMessage()
            ]);
        }
    }

}
