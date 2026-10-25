<?php

namespace App\Support;

use App\Mail\AdminInquiryNotification;
use App\Mail\EbookFormSubmitted;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * One place where a public form submission turns into email.
 *
 * Every form posts different field names (`full_name` vs `name`, `mobile` vs
 * `phone_number`, `suggestion` vs `message`), so each controller used to be on
 * its own — and the exit-intent popup simply never mailed anyone. Controllers
 * now hand the saved row here and both templates read one normalised shape.
 */
class LeadNotifier
{
    /**
     * Mail the admin, and the visitor too when they left an address.
     *
     * Never throws: the submission is already stored by the time we get here,
     * and a mailer outage must not turn a captured lead into a 500.
     */
    public static function notify(FormSubmission $submission): void
    {
        $data = self::payload($submission);

        try {
            if (!empty($data['email'])) {
                Mail::to($data['email'])->send(new EbookFormSubmitted($data));
            }

            Mail::to(config('admin.inquiry_notification_email', 'dheer725@gmail.com'))
                ->send(new AdminInquiryNotification($data));
        } catch (\Throwable $e) {
            Log::error('Lead notification mail failed: ' . $e->getMessage(), [
                'submission_id' => $submission->id,
                'source_form'   => $submission->source_form,
            ]);
        }
    }

    /**
     * The shape both blade templates expect.
     *
     * The `full_name` / `phone_number` keys are kept because the existing
     * templates and the property-inquiry mails already speak them.
     */
    public static function payload(FormSubmission $submission): array
    {
        return [
            'full_name'    => $submission->name ?: null,
            'phone_number' => $submission->phone ?: null,
            'email'        => $submission->email ?: null,
            'message'      => $submission->message ?: null,
            'source_form'  => $submission->source_form,
            'form_label'   => $submission->form_label,
            'page_url'     => $submission->source_page,
            'referrer_url' => $submission->referrer_url,
            'ip_address'   => $submission->ip_address,
            'submitted_at' => $submission->created_at ?? now(),
            'submission_id' => $submission->id,
        ];
    }
}
