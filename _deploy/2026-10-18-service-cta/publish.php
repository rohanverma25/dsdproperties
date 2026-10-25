<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__;
foreach([37,43,70,71,77,80,81,84,102,116,119,131,133,135,151,152,153] as $id){
 $old=file_get_contents("$d/$id.before.html"); $new=@file_get_contents("$d/$id.new.html");
 if(!$new || substr_count($new,'<!-- verify-cta -->')!==1 || strlen($new)<=strlen($old) || strlen($new)-strlen($old)>2500) { echo "ABORT $id\n"; continue; }
 $n=DB::table('blog_posts')->where('id',$id)->where('content_html',$old)->update(['content_html'=>$new,'updated_at'=>now()]);
 echo "post $id updated rows: $n\n"; }
