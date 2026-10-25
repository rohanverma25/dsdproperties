<?php
// 24 Oct 2026: publish 3 stories (created_at from stories.json) and insert 3 update boxes before a named <h2> in older stories.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==3) exit("ABORT\n");
$U=json_decode(file_get_contents(__DIR__.'/updates.json'),true);

foreach($S as $s){ if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','updated_at'=>now()])); echo "inserted {$s['slug']}\n"; }

$backup=[];
foreach($U as $u){
 $row=DB::table('news_articles')->find($u['id']); if(!$row){ echo "missing {$u['id']}\n"; continue; }
 $html=$row->full_content;
 if(str_contains($html,strip_tags(explode('</p>',$u['box'])[0]))){ echo "already updated {$u['id']}\n"; continue; }
 $re='~<h2[^>]*>\s*'.preg_quote($u['before_h2'],'~').'\s*</h2>~u';
 if(preg_match_all($re,$html,$m)!==1){ echo "anchor not found once in {$u['id']}\n"; continue; }
 $new=preg_replace($re,$u['box'].'$0',$html,1);
 $backup[$u['id']]=$html;
 DB::table('news_articles')->where('id',$u['id'])->where('full_content',$html)->update(['full_content'=>$new,'updated_at'=>now()]);
 echo "updated {$u['id']}\n";
}
if($backup) file_put_contents(__DIR__.'/backup-updates.json',json_encode($backup,JSON_UNESCAPED_UNICODE));
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
