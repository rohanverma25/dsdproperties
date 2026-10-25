<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ChecksHoneypot;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use App\Support\LeadNotifier;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InquiryController extends Controller
{
    use ChecksHoneypot;

    /**
     * Contact-us page and the blog sidebar both post here. They are told apart
     * by the hidden `source_form` field — before this existed both were stored
     * under the same label and could not be distinguished in the data.
     */
    public function submit(Request $request)
    {
        try {
            if ($this->isSpam($request)) {
                return $this->silentSuccess();
            }
            if ($fail = $this->turnstileFailed($request)) {
                return $fail;
            }

            $validated = $request->validate([
                'full_name'    => 'required|string|min:2|max:160',
                'phone_number' => 'required|string|digits_between:10,20',
                'email'        => 'nullable|email',
                'message'      => 'required|string|min:5|max:1000',
                'page_url'     => 'nullable|url',
                'referrer_url' => 'nullable|string|max:500',
                'source_form'  => ['nullable', Rule::in([
                    FormSubmission::FORM_CONTACT_US,
                    FormSubmission::FORM_BLOG_SIDEBAR,
                ])],
            ]);

            $submission = FormSubmission::create([
                'name'         => $validated['full_name'],
                'phone'        => $validated['phone_number'],
                'email'        => $validated['email'] ?? null,
                'message'      => $validated['message'],
                // An older cached page may post without the field; those rows
                // are marked legacy rather than attributed to the wrong form.
                'source_form'  => $validated['source_form'] ?? FormSubmission::FORM_LEGACY,
                'source_page'  => $validated['page_url'] ?? null,
                'referrer_url' => $validated['referrer_url'] ?? null,
                'ip_address'   => $request->ip(),
            ]);

            // Never costs us the submission — the row is already saved and
            // LeadNotifier swallows any mailer failure.
            LeadNotifier::notify($submission);

            return response()->json(['success' => true]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error('Inquiry form submission failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function subscribe(Request $request)
    {
        if ($this->isSpam($request)) {
            return response()->json(['message' => 'Thank you for subscribing!']);
        }

        // Bot guard (added 23 Oct 2026 after ~300 fake sign-ups on 18–20 Oct, which also made us send
        // thank-you emails to strangers). Our two newsletter forms always send page_url and ts (page-load
        // time, set by JS). Scripts posting straight to /subscribe send neither. Rejected posts get the
        // normal reply so the bot can't tell, and are logged.
        $bare     = fn ($h) => preg_replace('/^www\./', '', strtolower((string) $h));
        $pageHost = $bare(parse_url((string) $request->input('page_url'), PHP_URL_HOST));
        $ts       = (int) $request->input('ts');
        $age      = $ts ? (int) floor(microtime(true) * 1000) - $ts : null;
        if (! $pageHost || $pageHost !== $bare($request->getHost()) || $age === null || $age < 3000) {
            \Illuminate\Support\Facades\Log::info('Newsletter sign-up dropped by bot guard', [
                'email' => $request->input('email'), 'page_url' => $request->input('page_url'),
                'age_ms' => $age, 'ip' => $request->ip(), 'user_agent' => $request->userAgent(),
            ]);
            return response()->json(['message' => 'Thank you for subscribing!']);
        }

        if ($fail = $this->turnstileFailed($request)) {
            return $fail;
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'This email is already subscribed or invalid.'], 422);
        }

        // Already subscribed: no second row and no second thank-you email
        if (FormSubmission::where('source_form', FormSubmission::FORM_NEWSLETTER)->where('email', $request->input('email'))->exists()) {
            return response()->json(['message' => 'You are already subscribed. Thank you!']);
        }

        $submission = FormSubmission::create([
            'email'       => $request->input('email'),
            'source_form' => FormSubmission::FORM_NEWSLETTER,
            'source_page' => $request->input('page_url'),
            'ip_address'  => $request->ip(),
        ]);

        // A subscriber always leaves an address, so the thank-you always goes out.
        LeadNotifier::notify($submission);

        return response()->json(['message' => 'Thank you for subscribing!']);
    }

    public function ShowContcatUs()
    {
        return view('pages.contact-us');
    }
}
