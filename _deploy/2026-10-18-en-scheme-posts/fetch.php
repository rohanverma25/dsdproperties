<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
foreach([105,106,91,92,95,96] as $id){ $p=DB::table('blog_posts')->where('id',$id)->first();
 file_put_contents(__DIR__."/$id.before.html",$p->content_html);
 file_put_contents(__DIR__."/$id.meta.json",json_encode(collect((array)$p)->except('content_html'),JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
 printf("%d %s | len %d | updated %s\n",$id,$p->slug,strlen($p->content_html),$p->updated_at); }
