<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$id=(int)$argv[1]; $d=__DIR__;
$old=file_get_contents("$d/$id.before.html"); $new=@file_get_contents("$d/$id.new.html"); $meta=json_decode(@file_get_contents("$d/$id.newmeta.json"),true);
if(!$new || !$meta || strlen($new)<strlen($old)*(float)($argv[2]??0.6) || strpos($new,'<section id="FAQs">')===false || strpos($new,'<style')!==0) exit("ABORT $id\n");
$n=DB::table('blog_posts')->where('id',$id)->where('content_html',$old)->update(array_merge($meta,['content_html'=>$new,'updated_at'=>now()]));
echo "post $id updated rows: $n\n";
