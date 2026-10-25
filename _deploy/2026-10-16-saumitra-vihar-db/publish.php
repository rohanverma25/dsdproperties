<?php
// Publishes the Saumitra Vihar location map + fixes to posts 95/96. Run from project root.
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__;
foreach ([95,96] as $id) {
  $old=file_get_contents("$d/$id.before.html"); $new=@file_get_contents("$d/$id.new.html"); $sc=@file_get_contents("$d/$id.schema.new.json"); $meta=@file_get_contents("$d/$id.meta.new.txt");
  if (!$new || strlen($new)<strlen($old)+5000 || strpos($new,'svmap-wrap')===false || strpos($new,'60.29')!==false) exit("ABORT $id: new file missing or wrong\n");
  if (!$sc || json_decode($sc)===null) exit("ABORT $id: schema invalid\n");
  if (!$meta || strpos($meta,'RERA registered')!==false) exit("ABORT $id: meta wrong\n");
  $n=DB::table('blog_posts')->where('id',$id)->where('content_html',$old)->update(['content_html'=>$new,'seo_schema'=>$sc,'meta_description'=>$meta,'updated_at'=>now()]);
  echo "post $id updated rows: $n\n";
}
