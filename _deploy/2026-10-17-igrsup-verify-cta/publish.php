<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__;
foreach([115,120] as $id){ $old=file_get_contents("$d/$id.before.html"); $new=@file_get_contents("$d/$id.new.html");
 if(!$new || strpos($new,'verify-cta')===false || strlen($new)<strlen($old)) exit("ABORT $id\n");
 $n=DB::table('blog_posts')->where('id',$id)->where('content_html',$old)->update(['content_html'=>$new,'updated_at'=>now()]);
 echo "post $id updated rows: $n\n"; }
