<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrmLeadRequest;
use App\Http\Requests\LogCrmActivityRequest;
use App\Models\CrmLead;
use App\Models\CrmLeadActivity;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CrmLeadController extends Controller
{
    /** Screen 1 — Today. The default landing screen. */
    public function index()
    {
        $leads = CrmLead::dueToday()
            ->with('latestActivity')
            ->orderBy('next_followup_at')
            ->get();

        CrmLead::loadWhatsappSummary($leads);

        return view('admin.crm.leads.today', [
            'leads'       => $leads,
            'dueCount'    => $leads->count(),
            'overdueCount'=> $leads->where('is_overdue', true)->count(),
        ]);
    }

    /**
     * Temporary diagnostic for the "Today is empty" report.
     * Visit /admin/crm/leads/debug on the server, then delete this method
     * and its route once the cause is found.
     */
    public function debug()
    {
        $q = CrmLead::dueToday();

        return response()->json([
            'php_date'          => date('Y-m-d H:i:s'),
            'php_default_tz'    => date_default_timezone_get(),
            'app_timezone'      => config('app.timezone'),
            'laravel_now'       => (string) now(),
            'laravel_today'     => now()->toDateString(),
            'db_now'            => optional(\DB::selectOne('select now() as n, curdate() as d'))->n,
            'db_curdate'        => optional(\DB::selectOne('select now() as n, curdate() as d'))->d,
            'due_today_sql'     => $q->toSql(),
            'due_today_binds'   => $q->getBindings(),
            'due_today_count'   => $q->count(),
            'total_leads'       => CrmLead::count(),
            'all_rows'          => CrmLead::select('id', 'name', 'stage', 'next_followup_at', 'deleted_at')
                                          ->withTrashed()->get(),
            'activities_table'  => \Schema::hasTable('crm_lead_activities') ? 'exists' : 'MISSING',
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /** Screen 3 — All leads, searchable and filterable. */
    public function all(Request $request)
    {
        $leads = CrmLead::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term   = trim($request->input('q'));
                $digits = preg_replace('/\D+/', '', $term);

                $q->where(function ($w) use ($term, $digits) {
                    $w->where('name', 'like', "%{$term}%");
                    if ($digits !== '') {
                        $w->orWhere('phone', 'like', "%{$digits}%")
                          ->orWhere('alt_phone', 'like', "%{$digits}%");
                    }
                });
            })
            ->when($request->filled('stage'), fn ($q) => $q->where('stage', $request->input('stage')))
            ->when($request->filled('scheme_interest'), fn ($q) => $q->where('scheme_interest', $request->input('scheme_interest')))
            ->with('latestActivity')
            ->orderByRaw('next_followup_at is null, next_followup_at asc')
            ->paginate(25)
            ->withQueryString();

        CrmLead::loadWhatsappSummary($leads->getCollection());

        return view('admin.crm.leads.index', [
            'leads'   => $leads,
            'schemes' => CrmLead::whereNotNull('scheme_interest')->distinct()->orderBy('scheme_interest')->pluck('scheme_interest'),
        ]);
    }

    /**
     * Screen 5 — Waiting. Leads on hold for something that hasn't happened yet,
     * counted by scheme and reason, so when a registry opens or a plot comes
     * in, everyone who wanted it can be messaged and moved back to Today.
     */
    public function waiting(Request $request)
    {
        $groups = CrmLead::waiting()
            ->selectRaw('scheme_interest, waiting_for, count(*) as total')
            ->groupBy('scheme_interest', 'waiting_for')
            ->orderBy('scheme_interest')
            ->get();

        $leads = CrmLead::waiting()
            ->when($request->has('scheme_interest'), fn ($q) => $request->filled('scheme_interest')
                ? $q->where('scheme_interest', $request->input('scheme_interest'))
                : $q->whereNull('scheme_interest'))
            ->when($request->filled('waiting_for'), fn ($q) => $q->where('waiting_for', $request->input('waiting_for')))
            ->orderBy('scheme_interest')
            ->oldest()
            ->get();

        return view('admin.crm.leads.waiting', [
            'groups'   => $groups,
            'leads'    => $leads,
            'filtered' => $request->hasAny(['scheme_interest', 'waiting_for']),
        ]);
    }

    /** "Back to Today" — for one lead or the whole filtered list. */
    public function release(Request $request)
    {
        $data = $request->validate([
            'ids'   => ['required', 'array', 'max:500'],
            'ids.*' => ['integer'],
        ]);

        $leads = CrmLead::waiting()->whereKey($data['ids'])->get();
        $leads->each->releaseFromWaiting();

        return back()->with('success', $leads->count() . ' ' . Str::plural('lead', $leads->count()) . ' moved back to Today.');
    }

    public function create(Request $request)
    {
        $lead       = new CrmLead(['stage' => 'new']);
        $submission = $this->submissionFrom($request);

        // Arrived here via "Convert to lead" on the enquiries inbox — carry the
        // contact details across so nothing is retyped. The operator still has
        // to supply intent, budget and a follow-up date, which no form collects.
        if ($submission) {
            $lead->fill([
                'name'           => $submission->name,
                'phone'          => $submission->phone,
                'source_page'    => $submission->source_page,
                'source_channel' => 'form',
                'notes'          => $submission->message,
            ]);
        }

        return view('admin.crm.leads.create', [
            'lead'       => $lead,
            'submission' => $submission,
        ]);
    }

    /** The enquiry a convert-to-lead hand-off came from, if any. */
    private function submissionFrom(Request $request): ?FormSubmission
    {
        $id = $request->input('from_submission');

        return $id ? FormSubmission::whereNull('crm_lead_id')->find($id) : null;
    }

    /**
     * Ties an inbox enquiry to the lead it produced, so it cannot be converted
     * twice and the origin stays visible on the lead's timeline.
     */
    private function linkSubmission(?FormSubmission $submission, CrmLead $lead): void
    {
        if (! $submission || $submission->crm_lead_id) {
            return;
        }

        $submission->update([
            'crm_lead_id'  => $lead->id,
            'status'       => 'converted',
            'converted_at' => now(),
        ]);

        CrmLeadActivity::create([
            'crm_lead_id' => $lead->id,
            'type'        => 'note',
            'note'        => 'Converted from a ' . $submission->form_label . ' enquiry received '
                             . $submission->created_at->format('d M Y')
                             . ($submission->message ? ' — "' . $submission->message . '"' : ''),
            'happened_at' => now(),
        ]);
    }

    public function store(CrmLeadRequest $request)
    {
        // A number we already track is the same person — open them instead of
        // creating a second card for the same phone.
        $existing   = CrmLead::withTrashed()->matchingPhone($request->input('phone'))->first();
        $submission = $this->submissionFrom($request);

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }

            // Repeat enquiry from someone already on file: attach it to their
            // existing card rather than failing on the unique phone column.
            $this->linkSubmission($submission, $existing);

            return redirect()
                ->route('admin.crm.leads.show', $existing)
                ->with('info', 'This number already exists — opened the existing lead.');
        }

        $lead = CrmLead::create($request->validated());

        $this->linkSubmission($submission, $lead);

        return redirect()
            ->route('admin.crm.leads.show', $lead)
            ->with('success', 'Lead saved.');
    }

    /** Screen 4 — Lead detail with a reverse-chronological timeline. */
    public function show(CrmLead $lead)
    {
        $lead->load(['activities', 'latestActivity']);
        CrmLead::loadWhatsappSummary($lead->newCollection([$lead]));

        return view('admin.crm.leads.show', [
            'lead'     => $lead,
            'timeline' => $lead->timeline(),
        ]);
    }

    public function edit(CrmLead $lead)
    {
        return view('admin.crm.leads.edit', compact('lead'));
    }

    public function update(CrmLeadRequest $request, CrmLead $lead)
    {
        $lead->update($request->validated());

        return redirect()
            ->route('admin.crm.leads.show', $lead)
            ->with('success', 'Lead updated.');
    }

    public function destroy(CrmLead $lead)
    {
        $lead->delete();

        return redirect()
            ->route('admin.crm.leads.index')
            ->with('success', 'Lead deleted.');
    }

    /** Screen 2 — the activity modal posts here. */
    public function log(LogCrmActivityRequest $request, CrmLead $lead)
    {
        $data    = $request->validated();
        $outcome = $data['outcome'] ?? null;
        $rules   = $outcome ? config("crm.outcomes.{$outcome}") : null;

        $lead->activities()->create([
            'type'        => $data['type'],
            'outcome'     => $outcome,
            'note'        => $data['note'] ?? null,
            'happened_at' => now(),
        ]);

        $lead->last_contact_at  = now();
        $lead->next_followup_at = $data['next_followup_at'] ?? null;

        if ($rules && $rules['stage']) {
            $lead->stage = $rules['stage'];
        }

        if ($outcome === 'no_answer') {
            $lead->no_answer_count++;

            // Repeatedly unreachable — park the lead so it stops filling up Today.
            if ($lead->no_answer_count >= config('crm.no_answer_limit')) {
                $lead->stage            = 'dormant';
                $lead->next_followup_at = null;
            }
        } else {
            $lead->no_answer_count = 0;
        }

        $lead->save();

        return back()->with('success', 'Activity logged.');
    }
}
