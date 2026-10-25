<?php
// Adds a one-line news update to the "Latest Update" box near the top of blog guides (blog_posts.content_html).
// Used with each /news run: the run's build.py writes blog_updates.json, then:
//     php _deploy/news-blog-sync/push_blog_updates.php _deploy/<run>/blog_updates.json [--dry]
// Each entry: {id, date, li, replace?: [[old,new],...], new_box_title?}
//   - li goes in as the first <li> of the box (newest first); the date in the box heading becomes `date`.
//   - If the box then has more than MAX_ITEMS bullets, the last (oldest) one is removed: one per run, so old
//     news drops off gradually.
//   - Bullets already in the box are a dated record and are never edited. `replace` pairs fix facts elsewhere in
//     the post (title, meta_description, blog_summary, seo_schema and content outside the box); each pair must match.
//   - No box: one is created before the first <h2> if new_box_title is given, otherwise the post is skipped.
//   - Running twice is safe: an entry whose text is already in the box is skipped.
// Note: the local .env points at the production DB, so this edits the live site. A backup is written next to the JSON.
const MAX_ITEMS = 6;
require __DIR__.'/../../vendor/autoload.php'; $app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$file = $argv[1] ?? exit("usage: php push_blog_updates.php blog_updates.json [--dry]\n");
$dry = in_array('--dry', $argv, true);
$B = json_decode(file_get_contents($file), true) ?: exit("bad json\n");

$MONTHS = 'January|February|March|April|May|June|July|August|September|October|November|December';
$HMONTHS = 'जनवरी|फरवरी|फ़रवरी|मार्च|अप्रैल|मई|जून|जुलाई|अगस्त|सितंबर|सितम्बर|अक्टूबर|अक्तूबर|नवंबर|नवम्बर|दिसंबर|दिसम्बर';
$DATE_RE = "~\d{1,2}\s+(?:$MONTHS|$HMONTHS)\s+\d{4}|(?:$MONTHS)\s+\d{1,2},\s+\d{4}~u";
// The update box: <div class="dsd-infobox" ...> <h4>..update..</h4> <ul> ... </ul> </div>
$BOX_RE = '~<div class="dsd-infobox"[^>]*>\s*<h4>(?:(?!</h4>).)*?(?:Update|अपडेट)(?:(?!</h4>).)*</h4>\s*<ul>.*?</ul>\s*</div>~su';

$backup = [];
foreach ($B as $e) {
    $row = DB::table('blog_posts')->find($e['id']);
    if (!$row) { echo "#{$e['id']}: missing\n"; continue; }
    $html = $row->content_html;
    $fields = ['content_html' => $html, 'title' => $row->title, 'meta_description' => $row->meta_description,
               'blog_summary' => $row->blog_summary, 'seo_schema' => $row->seo_schema];
    $item = '<li>'.$e['li'].'</li>';
    $key = mb_substr(trim(preg_replace('/\s+/u', ' ', strip_tags($e['li']))), 0, 80);

    if (preg_match($BOX_RE, $html, $m, PREG_OFFSET_CAPTURE)) {
        [$box, $pos] = $m[0];
        if (str_contains(preg_replace('/\s+/u', ' ', strip_tags($box)), $key)) { echo "#{$e['id']}: already has this update\n"; continue; }
        $new = preg_replace('~<ul>~', "<ul>\n    $item", $box, 1);
        $new = preg_replace_callback('~<h4>(.*?)</h4>~su', fn($h) => '<h4>'.preg_replace($DATE_RE, $e['date'], $h[1], 1).'</h4>', $new, 1);
        $dropped = '';
        if (preg_match_all('~\s*<li\b.*?</li>~su', $new, $li) > MAX_ITEMS) {
            $last = end($li[0]);
            $dropped = mb_substr(trim(strip_tags($last)), 0, 70);
            $new = substr_replace($new, '', strrpos($new, $last), strlen($last));
        }
        $before = substr($html, 0, $pos); $after = substr($html, $pos + strlen($box));
        $note = $dropped !== '' ? " (dropped oldest: \"{$dropped}…\")" : '';
    } elseif (!empty($e['new_box_title'])) {
        $pos = strpos($html, '<h2');
        if ($pos === false) { echo "#{$e['id']}: no box and no <h2>\n"; continue; }
        $new = "<div class=\"dsd-infobox\" style=\"margin-bottom:24px;\">\n  <h4>{$e['new_box_title']}</h4>\n  <ul>\n    $item\n  </ul>\n</div>\n\n";
        $before = substr($html, 0, $pos); $after = substr($html, $pos);
        $note = ' (new box)';
    } else { echo "#{$e['id']}: no update box, skipped\n"; continue; }

    // Fact fixes outside the box
    $upd = ['content_html' => null] + array_fill_keys(['title', 'meta_description', 'blog_summary', 'seo_schema'], null);
    $missing = [];
    foreach ($e['replace'] ?? [] as [$old, $rep]) {
        $hits = substr_count($before.$after, $old);
        foreach (['title', 'meta_description', 'blog_summary', 'seo_schema'] as $f) $hits += substr_count((string)($upd[$f] ?? $fields[$f]), $old);
        if (!$hits) { $missing[] = $old; continue; }
        $before = str_replace($old, $rep, $before); $after = str_replace($old, $rep, $after);
        foreach (['title', 'meta_description', 'blog_summary', 'seo_schema'] as $f) {
            $v = (string)($upd[$f] ?? $fields[$f]);
            if (str_contains($v, $old)) $upd[$f] = str_replace($old, $rep, $v);
        }
    }
    $upd['content_html'] = $before.$new.$after;
    $upd = array_filter($upd, fn($v) => $v !== null);
    echo "#{$e['id']}: added{$note}; changed ".implode(', ', array_keys($upd)).($missing ? '; replace not found: '.implode(' | ', $missing) : '')."\n";
    if ($dry) continue;
    $backup[$e['id']] = $fields;
    DB::table('blog_posts')->where('id', $e['id'])->where('content_html', $html)->update($upd + ['updated_at' => now()]);
}
if ($backup) {
    $bf = dirname(realpath($file)).'/backup-blog-'.date('Ymd-His').'.json';
    file_put_contents($bf, json_encode($backup, JSON_UNESCAPED_UNICODE)); echo "backup: $bf\n";
}
