<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$d=__DIR__; $urls=[];
foreach([115,120,119,135] as $id){
  $old=file_get_contents("$d/$id.before.html"); $new=@file_get_contents("$d/$id.new.html"); $f=json_decode(@file_get_contents("$d/$id.fields.json"),true);
  if(!$new || strlen($new)<strlen($old) || !$f || json_decode($f['seo_schema'])===null || !$f['title']) exit("ABORT $id\n");
  $n=DB::table('blog_posts')->where('id',$id)->where('content_html',$old)->update(['content_html'=>$new,'title'=>$f['title'],'meta_description'=>$f['meta_description'],'seo_schema'=>$f['seo_schema'],'updated_at'=>now()]);
  echo "post $id updated rows: $n\n"; $urls[]='https://dsdproperties.in/blog/'.DB::table('blog_posts')->where('id',$id)->value('slug');
}
file_put_contents("$d/urls.json",json_encode($urls));
