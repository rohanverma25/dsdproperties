<?php
// 20 Oct 2026: publish 4 hand-checked stories + add confirmed 2 Nov last date to the Aditi story.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==4) exit("ABORT\n");
$order=['awas-vikas-e-nilami-5-november-2026-lucknow-registration','lda-board-outer-ring-road-500-meter-nirman-rok-prastav-october-2026','awas-vikas-pm-awas-flat-lucknow-jahirpur-anaura-registration-november-2026','green-corridor-ghaila-pul-naimish-nagar-9-9-km-lda-october-2026'];
foreach($S as $s){ if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 $t=now()->subMinutes(array_search($s['slug'],$order)*5);
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','created_at'=>$t,'updated_at'=>$t])); echo "inserted {$s['slug']}\n"; }

// Aditi Apartment: last date now confirmed
$slug='lda-aditi-apartment-anant-nagar-pmay-flat-registration-october-2026';
$row=DB::table('news_articles')->where('slug',$slug)->first();
$old='पंजीकरण की आखिरी तारीख और पंजीकरण राशि पोर्टल की बुकलेट में जरूर देख लें।';
$new='पंजीकरण की <strong>आखिरी तारीख 2 नवंबर 2026</strong> है (<a href="https://www.timesnowhindi.com/business/lucknow-housing-scheme-registration-opens-for-2-bhk-flats-in-aditi-apartments-article-156262967" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">टाइम्स नाउ हिंदी</a>)। पंजीकरण राशि पोर्टल की बुकलेट में जरूर देख लें।';
if(!$row) echo "Aditi story not found\n";
elseif(substr_count($row->full_content,$old)!==1) echo "Aditi: anchor text not found once, skipped\n";
else { DB::table('news_articles')->where('id',$row->id)->update(['full_content'=>str_replace($old,$new,$row->full_content),'updated_at'=>now()]); echo "Aditi story updated (id {$row->id})\n"; }
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
