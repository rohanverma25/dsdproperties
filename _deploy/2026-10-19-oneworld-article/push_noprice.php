<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); $d=__DIR__;
$old=file_get_contents("$d/current.html"); $r=json_decode(file_get_contents("$d/row.json"),true);
if(strpos($r['content_html'],'BSP')!==false||strpos($r['content_html'],'ow-grid-css')===false) exit("ABORT\n");
$n=DB::table('blog_posts')->where('id',173)->where('content_html',$old)->update(['content_html'=>$r['content_html'],'title'=>$r['title'],'meta_description'=>$r['meta_description'],'meta_keywords'=>$r['meta_keywords'],'blog_summary'=>$r['blog_summary'],'alt'=>$r['alt'],'seo_schema'=>$r['seo_schema'],'updated_at'=>now()]);
echo "173 updated $n\n";
$c=DB::table('blog_posts')->where('id',170)->value('content_html');
$a='all 10 projects on sale with BSP from ₹9,000 per sq ft (from 1 August 2026), super built-up and carpet areas,';
if(substr_count($c,$a)!==1) exit("ABORT 170 text not found\n");
file_put_contents("$d/post170.before-noprice.html",$c);
$n=DB::table('blog_posts')->where('id',170)->where('content_html',$c)->update(['content_html'=>str_replace($a,'all 10 projects on sale with super built-up and carpet areas,',$c),'updated_at'=>now()]);
echo "170 updated $n\n";
