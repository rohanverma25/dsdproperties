<?php
// 21 Oct 2026 (second run): publish the 662-villages story, dated to its report date (20 Oct) so /news stays date-wise.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==1) exit("ABORT\n");
$dates=['2026-10-20 09:00:00'];
foreach($S as $i=>$s){ if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','created_at'=>$dates[$i],'updated_at'=>now()])); echo "inserted {$s['slug']}\n"; }
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
