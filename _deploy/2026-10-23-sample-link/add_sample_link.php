<?php
// Adds a "रिपोर्ट देखें →" link (opens the sample verification report PDF) under every ₹5,000
// verification button in blog posts and news stories. Backs up every row it changes first,
// skips rows already done (marker class), and writes with a where-original guard.
// Usage: php add_sample_link.php [--dry]
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$dry  = in_array('--dry', $argv);
$pdf  = 'https://dsdproperties.in/public/downloads/DSD-Property-Verification-Sample-Report-Lucknow.pdf';
$link = '<p class="dsd-sample-link" style="margin:8px 0 0;font-size:14px;text-align:center;"><a href="'.$pdf.'" target="_blank" rel="noopener" style="color:#008080;font-weight:700;text-decoration:underline;">रिपोर्ट देखें →</a></p>';

// Exact button endings to insert after (each is the end of the paragraph holding the button)
$blogAnchors = [
    '{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}</p>',
    '{{CONSULTATION_BUTTON:प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000}}</p>',
];
$newsAnchors = ['प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000</a></p>'];

$backup = [];
$report = ['blog' => [], 'news' => []];

$apply = function (string $html, array $anchors) use ($link): array {
    if (str_contains($html, 'dsd-sample-link')) return [$html, 0];
    $n = 0;
    foreach ($anchors as $a) {
        $c = substr_count($html, $a);
        if ($c) { $html = str_replace($a, $a . $link, $html); $n += $c; }
    }
    return [$html, $n];
};

foreach (DB::table('blog_posts')->get(['id', 'content_html']) as $r) {
    [$new, $n] = $apply((string) $r->content_html, $blogAnchors);
    // Posts 91/105: the button token stands on its own line, not inside a <p>
    if (!$n && !str_contains((string) $r->content_html, 'dsd-sample-link')) {
        [$new, $n] = $apply((string) $r->content_html, ['{{CONSULTATION_BUTTON:Get Property Verified — ₹5,000}}', '{{CONSULTATION_BUTTON:प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000}}']);
    }
    if (!$n) continue;
    $backup['blog'][$r->id] = $r->content_html;
    $report['blog'][$r->id] = $n;
    if (!$dry) DB::table('blog_posts')->where('id', $r->id)->where('content_html', $r->content_html)->update(['content_html' => $new]);
}
foreach (DB::table('news_articles')->where('status', 'published')->get(['id', 'full_content']) as $r) {
    [$new, $n] = $apply((string) $r->full_content, $newsAnchors);
    if (!$n) continue;
    $backup['news'][$r->id] = $r->full_content;
    $report['news'][$r->id] = $n;
    if (!$dry) DB::table('news_articles')->where('id', $r->id)->where('full_content', $r->full_content)->update(['full_content' => $new]);
}

if (!$dry) file_put_contents(__DIR__.'/backup-'.date('Ymd-His').'.json', json_encode($backup, JSON_UNESCAPED_UNICODE));
echo ($dry ? "[dry run] " : ""), "blogs: ", count($report['blog']), " posts, ", array_sum($report['blog']), " links | news: ",
     count($report['news']), " stories, ", array_sum($report['news']), " links\n";
echo "blog ids: ", implode(',', array_keys($report['blog'])), "\nnews ids: ", implode(',', array_keys($report['news'])), "\n";
