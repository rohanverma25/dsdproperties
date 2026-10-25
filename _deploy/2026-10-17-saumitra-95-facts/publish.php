<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__; $old=file_get_contents("$d/95.before.html"); $new=@file_get_contents("$d/95.new.html"); $sc=@file_get_contents("$d/95.schema.new.json");
if(!$new || strpos($new,'16 October 2026')===false || strpos($new,'svmap-wrap')===false || strpos($new,'LOW = 4000')===false) exit("ABORT new\n");
if(!$sc || json_decode($sc)===null) exit("ABORT schema\n");
$n=DB::table('blog_posts')->where('id',95)->where('content_html',$old)->update(['content_html'=>$new,'seo_schema'=>$sc,'updated_at'=>now()]);
echo "post 95 updated rows: $n\n";
