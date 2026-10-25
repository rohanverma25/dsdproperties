<?php

namespace App\Http\Controllers;

use App\Support\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * /news/weekly — one page per week, built automatically from that week's /news stories.
 * The weekly newsletter email links here. Also handles the newsletter unsubscribe link.
 */
class NewsWeeklyController extends Controller
{
    public function index()
    {
        $weeks = Newsletter::weeks();
        if (! $weeks) {
            return redirect()->route('news.index');
        }
        return redirect()->route('news.weekly.show', array_key_first($weeks));
    }

    public function show(string $week)
    {
        $week = strtoupper($week);
        if (! Newsletter::weekRange($week)) {
            abort(404);
        }
        $stories = Newsletter::stories($week);
        $weeks   = Newsletter::weeks();
        if ($stories->isEmpty() && ! isset($weeks[$week])) {
            abort(404);
        }
        return view('news.weekly', [
            'week'      => $week,
            'weekLabel' => Newsletter::weekLabel($week),
            'stories'   => $stories,
            'weeks'     => array_slice($weeks, 0, 12, true),
        ]);
    }

    /*
     * Company mail scanners (Defender, Mimecast…) open every link in an email within seconds.
     * So a GET only shows a page with a button; the choice is saved on POST. Mail apps'
     * one-click unsubscribe is a POST to the same signed URL, so it keeps working.
     */

    /** Reader says which language they want the weekly email in (link in every email). */
    public function language(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'This link is not valid.');
        }
        $email = strtolower(trim((string) $request->query('email')));
        $lang  = $request->query('lang') === 'hi' ? 'hi' : 'en';
        if ($request->isMethod('post') && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            DB::table('newsletter_preferences')->updateOrInsert(['email' => $email], ['lang' => $lang, 'updated_at' => now(), 'created_at' => now()]);
            return view('news.unsubscribed', ['email' => $email, 'mode' => 'language', 'lang' => $lang, 'done' => true]);
        }
        return view('news.unsubscribed', ['email' => $email, 'mode' => 'language', 'lang' => $lang, 'done' => false]);
    }

    /** GET shows a confirm button; POST (our button or a mail app's one-click) unsubscribes. */
    public function unsubscribe(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'This unsubscribe link is not valid.');
        }
        $email = strtolower(trim((string) $request->query('email')));
        if (! $request->isMethod('post')) {
            return view('news.unsubscribed', ['email' => $email, 'mode' => 'unsubscribe', 'done' => false]);
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            DB::table('newsletter_unsubscribes')->insertOrIgnore([
                'email' => $email, 'campaign_id' => $request->query('c') ?: null,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        if ($request->has('List-Unsubscribe') || ! $request->has('confirm')) {
            return response('', 200);   // one-click POST from a mail app
        }
        return view('news.unsubscribed', ['email' => $email, 'mode' => 'unsubscribe', 'done' => true]);
    }
}
