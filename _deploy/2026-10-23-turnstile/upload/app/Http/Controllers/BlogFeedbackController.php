<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ChecksHoneypot;
use App\Models\FormSubmission;
use App\Support\LeadNotifier;
use Illuminate\Http\Request;

/**
 * The exit-intent popup on blog pages.
 *
 * Named "feedback" for historical reasons — it collects enquiries, and they
 * now land in `form_submissions` alongside every other form. The admin listing
 * lives on Admin\FormSubmissionController.
 */
class BlogFeedbackController extends Controller
{
    use ChecksHoneypot;

    public function store(Request $request)
    {
        if ($this->isSpam($request)) {
            return $this->silentSuccess();
        }
        if ($fail = $this->turnstileFailed($request)) {
            return $fail;
        }

        $validated = $request->validate([
            'name'       => 'required|string|min:2|max:100',
            'mobile'     => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            // Optional: the popup asks for an email but never blocks on it.
            // It is still checked when given, so junk does not reach the table.
            'email'      => 'nullable|email:rfc|max:191',
            'suggestion' => 'required|string|min:5|max:1000',
        ]);

        $submission = FormSubmission::create([
            'name'        => $validated['name'],
            'phone'       => $validated['mobile'],
            'email'       => $validated['email'] ?? null,
            'message'     => $validated['suggestion'],
            'source_form' => FormSubmission::FORM_EXIT_INTENT,
            'source_page' => $request->input('page_url') ?: null,
            'ip_address'  => $request->ip(),
        ]);

        // The popup used to save silently — no thank-you, no admin alert.
        LeadNotifier::notify($submission);

        return response()->json(['success' => true]);
    }
}
