<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EbookFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $name = $this->data['full_name'] ?? null;

        // A newsletter signup was never an enquiry, so it gets its own line.
        if (($this->data['source_form'] ?? null) === 'newsletter') {
            $subject = "You're subscribed — DSD Properties";
        } else {
            $subject = $name
                ? "Thank you, {$name} — we've received your enquiry"
                : 'Thank you for contacting DSD Properties';
        }

        return $this->subject($subject)
                    ->view('emails.inquiry_form');
    }
}
