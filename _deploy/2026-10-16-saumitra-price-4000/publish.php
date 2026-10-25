<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__;
foreach([95,96] as $id){ $old=file_get_contents("$d/$id.before.html"); $new=@file_get_contents("$d/$id.new.html"); $sc=@file_get_contents("$d/$id.schema.new.json");
 if(!$new || strlen($new)<strlen($old)-3000 || strpos($new,'4,000')===false || strpos($new,'svmap-wrap')===false) exit("ABORT $id new\n");
 if(!$sc || json_decode($sc)===null) exit("ABORT $id schema\n");
 $n=DB::table('blog_posts')->where('id',$id)->where('content_html',$old)->update(['content_html'=>$new,'seo_schema'=>$sc,'updated_at'=>now()]);
 echo "post $id updated rows: $n\n"; }
