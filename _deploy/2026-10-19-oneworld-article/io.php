<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); $d=__DIR__;
if($argv[1]==='get'){ file_put_contents("$d/current.html",DB::table('blog_posts')->where('id',173)->value('content_html')); echo "saved\n"; exit; }
$old=file_get_contents("$d/current.html"); $new=file_get_contents("$d/new.html");
if(strpos($new,'id="ow-grid"')===false||strpos($new,'ow-grid-css')===false) exit("ABORT\n");
$n=DB::table('blog_posts')->where('id',173)->where('content_html',$old)->update(['content_html'=>$new,'updated_at'=>now()]); echo "updated $n\n";
