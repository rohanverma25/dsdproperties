<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        // Naming the form in the subject makes the inbox sortable at a glance —
        // a newsletter signup and a contact-us enquiry need different urgency.
        $form = $this->data['form_label'] ?? 'Website Form';
        $who  = $this->data['full_name'] ?? ($this->data['email'] ?? 'Unknown visitor');

        $mail = $this->subject("🔥 New Lead — {$form} — {$who}")
                     ->view('emails.admin_inquiry');

        // Hitting reply in the inbox should reach the visitor, not us.
        if (!empty($this->data['email'])) {
            $mail->replyTo($this->data['email'], $this->data['full_name'] ?? null);
        }

        return $mail;
    }
}
