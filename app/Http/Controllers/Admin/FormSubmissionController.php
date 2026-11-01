<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrmLead;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * The single inbox for every public form on the site.
 *
 * Submissions are deliberately NOT auto-promoted into the CRM — most blog
 * popup entries are never worth a follow-up card. Promoting is a manual click
 * that hands off to the existing CRM create form.
 */
class FormSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $form   = $request->input('form');
        $status = $request->input('status');

        $submissions = FormSubmission::query()
            ->search($request->input('q'))
            ->when(
                is_string($form) && array_key_exists($form, FormSubmission::FORMS),
                fn ($q) => $q->where('source_form', $form),
                // Newsletter sign-ups would otherwise swamp a list you work
                // through, so they are opt-in via the filter.
                fn ($q) => $q->where('source_form', '!=', FormSubmission::FORM_NEWSLETTER)
            )
            ->when(
                in_array($status, FormSubmission::STATUSES, true),
                fn ($q) => $q->where('status', $status)
            )
            ->when($request->boolean('unhandled'), fn ($q) => $q->unhandled())
            ->with('crmLead')
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.form-submissions.index', [
            'submissions' => $submissions,
            'forms'       => FormSubmission::FORMS,
            'statuses'    => FormSubmission::STATUSES,
            'unhandledCount' => FormSubmission::unhandled()->count(),
        ]);
    }

    /**
     * Hands the submission to the CRM's own create form, pre-filled. The lead
     * is written by CrmLeadController::store, which already knows how to deal
     * with a phone number that is on file — this only supplies the values.
     */
    public function convert(FormSubmission $submission)
    {
        if ($submission->crm_lead_id) {
            return redirect()
                ->route('admin.crm.leads.show', $submission->crm_lead_id)
                ->with('info', 'This enquiry was already converted — opened the existing lead.');
        }

        if (! $submission->is_convertible) {
            return back()->with('error', 'This submission has no phone number, so it cannot become a lead.');
        }

        return redirect()->route('admin.crm.leads.create', [
            'from_submission' => $submission->id,
        ]);
    }

    /** Manual triage: mark junk as spam, or file a handled enquiry away. */
    public function status(Request $request, FormSubmission $submission)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['new', 'spam', 'archived'])],
        ]);

        // 'converted' is owned by the CRM hand-off and is never set by hand.
        if ($submission->status === 'converted') {
            return back()->with('error', 'A converted enquiry cannot be re-filed.');
        }

        $submission->update(['status' => $validated['status']]);

        return back()->with('success', 'Enquiry marked as ' . $validated['status'] . '.');
    }
}
