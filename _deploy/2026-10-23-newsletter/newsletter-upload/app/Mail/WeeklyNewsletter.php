<?php

namespace App\Mail;

use App\Models\NewsletterCampaign;
use App\Support\Newsletter;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;
use Symfony\Component\Mime\Email;

class WeeklyNewsletter extends Mailable
{
    public function __construct(
        public NewsletterCampaign $campaign,
        public Collection $stories,
        public string $recipient,
        public ?string $recipientName = null,
    ) {}

    public function build()
    {
        $unsubscribe = Newsletter::unsubscribeUrl($this->recipient, $this->campaign->id);

        $mail = $this->from(config('newsletter.from_address'), config('newsletter.from_name'))
            ->subject($this->campaign->subject)
            ->view('emails.weekly_newsletter', [
                'c'           => $this->campaign,
                'stories'     => $this->stories,
                'name'        => $this->recipientName,
                'weekLabel'   => Newsletter::weekLabel($this->campaign->week),
                'weekUrl'     => route('news.weekly.show', $this->campaign->week) . '?' . config('newsletter.utm') . '&utm_campaign=' . strtolower($this->campaign->week),
                'utm'         => config('newsletter.utm') . '&utm_campaign=' . strtolower($this->campaign->week),
                'unsubscribe' => $unsubscribe,
                'prefHindi'   => Newsletter::languageUrl($this->recipient, 'hi'),
                'prefEnglish' => Newsletter::languageUrl($this->recipient, 'en'),
            ]);

        if (config('newsletter.reply_to')) {
            $mail->replyTo(config('newsletter.reply_to'));
        }

        // One-click unsubscribe header: Gmail and Yahoo expect it for bulk mail
        $mail->withSymfonyMessage(function (Email $m) use ($unsubscribe) {
            $m->getHeaders()->addTextHeader('List-Unsubscribe', '<' . $unsubscribe . '>');
            $m->getHeaders()->addTextHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
        });

        return $mail;
    }
}
