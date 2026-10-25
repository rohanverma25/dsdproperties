<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==6) exit("ABORT\n");
$order=['varun-vihar-naimish-nagar-panjikaran-aakhiri-tarikh-24-october-2026','kisan-path-lda-naksha-manjuri-prastav-board-baithak-tali-october-2026','lda-avaidh-plotting-dhwast-sushant-golf-city-mohanlalganj-october-2026','up-rera-lucknow-12-projects-approved-october-2026','it-city-lucknow-lda-300-hectare-bhumi-adhigrahan-october-2026','lda-aditi-apartment-anant-nagar-pmay-flat-registration-october-2026'];
foreach($S as $s){ if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 $t=now()->subMinutes(array_search($s['slug'],$order)*5);
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','created_at'=>$t,'updated_at'=>$t])); echo "inserted {$s['slug']}\n"; }
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
