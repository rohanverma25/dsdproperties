<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); $d=__DIR__;
$old=file_get_contents("$d/current.html"); $new=file_get_contents("$d/new.html");
if(strpos($new,'oneworld-link')===false||strpos($new,'id="trust"')===false) exit("ABORT\n");
$n=DB::table('blog_posts')->where('id',170)->where('content_html',$old)->update(['content_html'=>$new,'updated_at'=>now()]); echo "updated $n\n";
