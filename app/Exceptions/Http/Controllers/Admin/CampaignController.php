<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Jobs\SendLeadEmailJob;
use App\Models\EmailTemplate;

class CampaignController extends Controller
{
    // 👉 SHOW CAMPAIGN PAGE (GET)
    public function index()
    {
        $totalLeads = Lead::whereNull('last_emailed_at')
            ->where('is_unsubscribed', 0)
            ->where('segment', 'web')
            ->orWhere('segment', 'general')
            ->where('is_email_sent', 0)
            ->count();

        return view('admin.campaigns.index', compact('totalLeads'));
    }

    // 👉 START CAMPAIGN (POST)
public function start(Request $request)
{
    $template = EmailTemplate::where('active', 1)->first();

    if (!$template) {
        return back()->with('error', 'No active email template found.');
    }

    $leads = Lead::where('is_email_sent', 0)
        ->where('is_unsubscribed', 0)
        ->where('segment', 'general')
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();

    if ($leads->isEmpty()) {
        return back()->with('info', 'No pending leads to email.');
    }

    foreach ($leads as $lead) {
        SendLeadEmailJob::dispatch($lead, $template->id)
            ->delay(now()->addSeconds(rand(10, 15)));
    }

    return back()->with('success', 'Campaign started successfully!');
}

public function unsubscribe(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect('/')->with('error', 'Invalid unsubscribe link.');
        }

        $lead = Lead::where('email', $email)->first();

        if (!$lead) {
            return redirect('/')->with('error', 'Email not found in our records.');
        }

        $lead->is_unsubscribed = 1;
        $lead->save();

        return redirect('/')->with('success', 'You have been unsubscribed successfully.');
    }
}
