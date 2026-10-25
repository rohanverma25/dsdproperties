<?php
// 22 Oct 2026 (second run): publish 1 story (dated 22 Oct) + update the bribery-sting story.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==1) exit("ABORT\n");
$U=json_decode(file_get_contents(__DIR__.'/updates.json'),true);
foreach($S as $i=>$s){ if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 $t="2026-10-22 11:00:00";
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','created_at'=>$t,'updated_at'=>$t])); echo "inserted {$s['slug']}\n"; }

foreach($U as $u){
 $row=DB::table('news_articles')->where('slug',$u['slug'])->first();
 if(!$row){ echo "not found {$u['slug']}\n"; continue; }
 if(substr_count($row->full_content,$u['anchor'])!==1){ echo "anchor not found once, skipped {$u['slug']}\n"; continue; }
 $new = isset($u['insert_before']) ? $u['insert_before'].$u['anchor'] : $u['replace_with'];
 if(str_contains($row->full_content,$new)){ echo "already updated {$u['slug']}\n"; continue; }
 DB::table('news_articles')->where('id',$row->id)->update(['full_content'=>str_replace($u['anchor'],$new,$row->full_content),'updated_at'=>now()]);
 echo "updated {$u['slug']} (id {$row->id})\n"; }
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
