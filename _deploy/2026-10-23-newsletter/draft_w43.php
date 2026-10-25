<?php
// Creates the first newsletter draft (week 2026-W43) with English headlines + summaries for its 11 Hindi stories.
// Facts are the same as in the published stories. Run once: php _deploy/2026-10-23-newsletter/draft_w43.php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$items = [
 167 => ['New ₹1,150/sq m completion charge planned in Sushant Golf City', 'LDA will put the charge to its November board meeting. It will be collected at map approval, completion certificate or compounding. EWS and LIG plots up to 50 sq m are exempt.'],
 168 => ['Ayodhya Road: shops and showrooms built on parking space to be removed', 'LDA will serve notices to complexes that use their approved parking area for shops or showrooms, and demolish what is not cleared in time. Check the approved map before buying a shop here.'],
 166 => ['UP RERA: Lucknow leads with 59 new projects in Jan–Sep 2026', '217 projects were registered in UP, with 66,158 units worth about ₹46,795 crore. Lucknow had the most projects: 59, with 15,959 units worth ₹5,795 crore.'],
 163 => ['Sushant Golf City: house demolished months after a full-payment registry', 'A buyer paid Ansal in full and got a registry in 2025, but the house was knocked down in a land dispute. A case has been filed. A registry alone does not prove the land is free of claims.'],
 164 => ['Pond land plotted under a changed khasra number; LDA orders a probe', 'In Puran Nagar Jodha Kheda, land recorded as a pond (khasra 01S) was allegedly sold as plots under khasra 3S. LDA engineers must report within three days.'],
 160 => ['Saumitra Vihar: 600 plots may open for registration around Diwali', 'Awas Vikas is preparing to open registration for the first 600 plots once RERA approval comes through.'],
 169 => ['Lucknow AI City to come up at Vrindavan IT City', 'The site has been chosen for an AI city-cum-business park, and more than 25 proposals have come in. A final land decision and a master developer are due within a year.'],
 162 => ['All 662 villages of Lucknow district proposed for the LDA area', 'A revised proposal has gone to the state government. If it is approved, unapproved plotting in these villages could face LDA action, so "outside LDA, no map needed" claims become risky.'],
 151 => ['Naimish Nagar: more plots to open within two months', 'LDA says registration for more plots will open within two months. The layout for the remaining half of the scheme goes to the board.'],
 152 => ['Plot fraud: money taken, no registry; cases filed in Chinhat, Vibhutikhand and Para', 'Five buyers lost ₹79.97 lakh in total. In three cases the full price was paid but the registry was never done. Pay the full amount only at the sub-registrar office.'],
 165 => ['Sting report claims a bribery "rate card" in development authorities; LDA forms a probe panel', 'A Bhaskar sting alleges fixed rates for unsealing buildings and allowing extra floors. LDA has set up a committee that must report in a week.'],
];
$data = [];
foreach ($items as $id => [$t, $sm]) { $data[$id] = ['title' => $t, 'summary' => $sm]; }

$subject = 'New ₹1,150/sq m charge in Sushant Golf City + 10 more Lucknow property updates';
$c = App\Models\NewsletterCampaign::where('week', '2026-W43')->where('status', 'draft')->first();
if ($c) {
    $c->update(['subject' => $subject, 'items' => $data]);
    echo "draft {$c->id} updated with ", count($data), " English headlines\n";
} elseif (! App\Models\NewsletterCampaign::where('week', '2026-W43')->exists()) {
    $c = App\Models\NewsletterCampaign::create(['week' => '2026-W43', 'subject' => $subject, 'items' => $data,
        'sources' => implode(',', array_keys(config('newsletter.sources'))), 'status' => 'draft']);
    echo "draft {$c->id} created with ", count($data), " English headlines\n";
} else {
    echo "2026-W43 campaign already started; not changed\n";
}
