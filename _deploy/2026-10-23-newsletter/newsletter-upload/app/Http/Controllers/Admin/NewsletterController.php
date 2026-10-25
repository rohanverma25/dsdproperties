<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WeeklyNewsletter;
use App\Models\NewsletterCampaign;
use App\Support\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * /admin/newsletter — build a weekly email from the week's /news stories, preview it,
 * send a test, then send to the audience in hourly batches (newsletter:send-batch)
 * or batch by batch with the button.
 */
class NewsletterController extends Controller
{
    public function index()
    {
        $weeks = Newsletter::weeks();
        $sourceCounts = [];
        foreach (array_keys(config('newsletter.sources')) as $src) {
            $sourceCounts[$src] = count(Newsletter::audience([$src]));
        }
        return view('admin.newsletter.index', [
            'weeks'        => $weeks,
            'sources'      => config('newsletter.sources'),
            'sourceCounts' => $sourceCounts,
            'allCount'     => count(Newsletter::audience(array_keys(config('newsletter.sources')))),
            'unsubscribed' => DB::table('newsletter_unsubscribes')->count(),
            'campaigns'    => NewsletterCampaign::latest()->limit(20)->get(),
            'configured'   => (bool) config('mail.mailers.newsletter.username') && (bool) config('newsletter.from_address'),
            // Which part of the setup is missing, shown on the page so it can be fixed without guessing
            'checks'       => [
                'config/newsletter.php uploaded'            => is_array(config('newsletter.sources')),
                'config/mail.php has the "newsletter" mailer' => is_array(config('mail.mailers.newsletter')),
                'NEWSLETTER_MAIL_USERNAME read from .env'   => (bool) config('mail.mailers.newsletter.username'),
                'NEWSLETTER_MAIL_PASSWORD read from .env'   => (bool) config('mail.mailers.newsletter.password'),
                'From address set'                          => (bool) config('newsletter.from_address'),
                'Config cache off (reads .env directly)'    => ! app()->configurationIsCached(),
            ],
            'batchSize'    => config('newsletter.batch_size'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'week'      => ['required', 'regex:/^\d{4}-W\d{2}$/'],
            'subject'   => ['required', 'string', 'max:190'],
            'intro'     => ['nullable', 'string', 'max:1000'],
            'sources'   => ['required', 'array', 'min:1'],
            'sources.*' => ['in:' . implode(',', array_keys(config('newsletter.sources')))],
        ]);
        if (Newsletter::stories($data['week'])->isEmpty()) {
            return back()->withInput()->with('error', 'That week has no published news stories.');
        }
        $c = NewsletterCampaign::create([
            'week' => $data['week'], 'subject' => $data['subject'], 'intro' => $data['intro'] ?? null,
            'sources' => implode(',', $data['sources']), 'status' => 'draft',
        ]);
        return redirect()->route('admin.newsletter.index')->with('success', "Draft saved for {$c->week}. Preview it and send yourself a test before starting.");
    }

    public function preview(NewsletterCampaign $campaign)
    {
        Newsletter::useSiteUrl();
        return (new WeeklyNewsletter($campaign, Newsletter::stories($campaign->week), 'preview@example.com', 'Preview'))->render();
    }

    public function test(Request $request, NewsletterCampaign $campaign)
    {
        $email = $request->validate(['email' => ['required', 'email']])['email'];
        Newsletter::useSiteUrl();
        try {
            Mail::mailer(config('newsletter.mailer'))->to($email)
                ->send(new WeeklyNewsletter($campaign, Newsletter::stories($campaign->week), $email, null));
        } catch (\Throwable $e) {
            return back()->with('error', 'Test email failed: ' . $e->getMessage());
        }
        return back()->with('success', "Test email sent to {$email}. Check the inbox and the spam folder.");
    }

    /** Save the English headline + summary used in the email for each story. */
    public function items(Request $request, NewsletterCampaign $campaign)
    {
        $data = $request->validate([
            'items'           => ['array'],
            'items.*.title'   => ['nullable', 'string', 'max:200'],
            'items.*.summary' => ['nullable', 'string', 'max:500'],
        ]);
        $items = [];
        foreach ($data['items'] ?? [] as $id => $i) {
            $items[(int) $id] = ['title' => trim($i['title'] ?? ''), 'summary' => trim($i['summary'] ?? '')];
        }
        $campaign->update(['items' => $items]);
        return back()->with('success', 'English headlines saved. Open Preview to check the email.');
    }

    public function start(NewsletterCampaign $campaign)
    {
        if ($campaign->status !== 'draft') {
            return back()->with('info', 'This campaign has already started.');
        }
        $total = Newsletter::start($campaign);
        [$sent, $failed, $left] = Newsletter::sendBatch($campaign->fresh());
        return back()->with('success', "Started: {$total} emails queued. First batch: {$sent} sent, {$failed} failed, {$left} left. The rest go out hourly.");
    }

    public function batch(NewsletterCampaign $campaign)
    {
        if ($campaign->status !== 'sending') {
            return back()->with('info', 'Nothing left to send for this campaign.');
        }
        [$sent, $failed, $left] = Newsletter::sendBatch($campaign);
        return back()->with('success', "Batch done: {$sent} sent, {$failed} failed, {$left} left.");
    }

    public function destroy(NewsletterCampaign $campaign)
    {
        if ($campaign->status !== 'draft') {
            return back()->with('error', 'Only drafts can be deleted.');
        }
        $campaign->delete();
        return back()->with('success', 'Draft deleted.');
    }
}
