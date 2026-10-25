<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__; $old=file_get_contents("$d/96.before.html"); $new=@file_get_contents("$d/96.new.html"); $sc=@file_get_contents("$d/96.schema.new.json");
if(!$new || strlen($new)<strlen($old) || strpos($new,'16 अक्टूबर 2026')===false || strpos($new,'svmap-wrap')===false) exit("ABORT new\n");
if(!$sc || json_decode($sc)===null) exit("ABORT schema\n");
$n=DB::table('blog_posts')->where('id',96)->where('content_html',$old)->update(['content_html'=>$new,'seo_schema'=>$sc,'updated_at'=>now()]);
echo "post 96 updated rows: $n\n";
