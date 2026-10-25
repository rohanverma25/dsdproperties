<?php
// 22 Oct 2026: publish 3 stories (Bhaskar/Hindustan text pasted by the user), dated to their report dates.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==3) exit("ABORT\n");
$dates=['2026-10-21 10:00:00','2026-10-21 09:00:00','2026-10-19 09:00:00'];
foreach($S as $i=>$s){ if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','created_at'=>$dates[$i],'updated_at'=>now()])); echo "inserted {$s['slug']}\n"; }
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
