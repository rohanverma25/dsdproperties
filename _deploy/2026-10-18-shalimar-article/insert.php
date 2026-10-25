<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$r=json_decode(file_get_contents(__DIR__.'/row.json'),true);
if(DB::table('blog_posts')->where('slug',$r['slug'])->exists()) exit("EXISTS\n");
$r['created_at']=now(); $r['updated_at']=now();
$id=DB::table('blog_posts')->insertGetId($r); echo "draft id $id\n";
