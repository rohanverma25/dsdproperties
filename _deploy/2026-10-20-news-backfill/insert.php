<?php
// 20 Oct 2026: backfill 8 stories (22 Sep – 20 Oct) at their news dates, and move existing stories to their news dates.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$S=json_decode(file_get_contents(__DIR__.'/stories.json'),true); if(count($S)!==8) exit("ABORT\n");

// id => [created_at, dateline text or null to leave the dateline alone]
$redate=[141=>['2026-10-17 10:00:00','17 अक्टूबर 2026'],142=>['2026-10-06 10:00:00',null],143=>['2026-10-16 18:00:00',null],
 144=>['2026-10-14 10:00:00','14 अक्टूबर 2026'],145=>['2026-10-02 10:00:00','2 अक्टूबर 2026'],147=>['2026-10-16 12:00:00','16 अक्टूबर 2026'],
 148=>['2026-10-17 18:00:00','17 अक्टूबर 2026'],149=>['2026-10-17 12:00:00','17 अक्टूबर 2026'],150=>['2026-10-16 10:00:00','16 अक्टूबर 2026'],
 151=>['2026-10-19 10:00:00','19 अक्टूबर 2026'],152=>['2026-10-19 09:00:00','19 अक्टूबर 2026']];

$bk=__DIR__.'/backup-before-redate.json';
if(!file_exists($bk)) file_put_contents($bk,json_encode(DB::table('news_articles')->whereIn('id',array_keys($redate))->get(['id','created_at','full_content']),JSON_UNESCAPED_UNICODE));

foreach($S as $s){ $d=$s['date']; unset($s['date']);
 if(DB::table('news_articles')->where('slug',$s['slug'])->exists()){ echo "EXISTS {$s['slug']}\n"; continue; }
 DB::table('news_articles')->insert(array_merge($s,['status'=>'published','created_at'=>$d,'updated_at'=>$d])); echo "inserted $d {$s['slug']}\n"; }

foreach($redate as $id=>[$at,$dl]){
 $row=DB::table('news_articles')->find($id); if(!$row){ echo "missing $id\n"; continue; }
 $upd=['created_at'=>$at];
 if($dl){ $n=preg_match_all('/लखनऊ • [^<]*</u',$row->full_content);
  if($n!==1){ echo "dateline not found once in $id, date only\n"; }
  else $upd['full_content']=preg_replace('/लखनऊ • [^<]*</u','लखनऊ • '.$dl.'<',$row->full_content,1); }
 DB::table('news_articles')->where('id',$id)->update($upd); echo "redated $id -> $at\n"; }
echo "published now: ",DB::table('news_articles')->where('status','published')->count(),"\n";
