<?php
// Restores the missing backslash in FAQ icon CSS for posts 81 and 160 ("2212" -> "\2212", "2013" -> "\2013").
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;
$bs = chr(92);
$fixes = [81 => ['content:"2212"', 'content:"' . $bs . '2212"'], 160 => ['content:"2013"', 'content:"' . $bs . '2013"']];
foreach ($fixes as $id => [$from, $to]) {
    $old = DB::table('blog_posts')->where('id', $id)->value('content_html');
    file_put_contents(__DIR__ . "/post{$id}.before.html", $old);
    if (substr_count($old, $from) !== 1) { echo "$id: expected 1 match, found " . substr_count($old, $from) . PHP_EOL; continue; }
    $new = str_replace($from, $to, $old);
    if (strlen($new) !== strlen($old) + 1) { echo "$id: length guard failed" . PHP_EOL; continue; }
    $n = DB::table('blog_posts')->where('id', $id)->where('content_html', $old)->update(['content_html' => $new]);
    echo "$id: updated $n row(s)" . PHP_EOL;
}
