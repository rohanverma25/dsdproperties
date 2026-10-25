<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__; $old=file_get_contents("$d/before.html"); $new=@file_get_contents("$d/new.html"); $meta=json_decode(@file_get_contents("$d/newmeta.json"),true);
if(!$new||!$meta||strlen($new)<strlen($old)||strpos($new,'dsd-key-facts')===false||strpos($new,'faqq-toggle-138')===false) exit("ABORT\n");
$n=DB::table('blog_posts')->where('id',138)->where('content_html',$old)->update(array_merge($meta,['content_html'=>$new,'updated_at'=>now()]));
echo "post 138 updated rows: $n\n";
