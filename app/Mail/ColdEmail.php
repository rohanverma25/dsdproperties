<?php

namespace App\Mail;

use App\Models\Lead;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ColdEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $template;

    public function __construct(Lead $lead, EmailTemplate $template)
    {
        $this->lead = $lead;
        $this->template = $template;
    }

    public function build()
    {
        return $this
            ->subject($this->template->subject)
            ->view('emails.cold')
            ->with([
                'lead' => $this->lead,
                'content' => $this->template->body,
            ]);
    }
}
