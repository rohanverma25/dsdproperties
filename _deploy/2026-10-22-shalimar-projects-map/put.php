<?php
// Replace the content of draft post 175 with new.html (guards: file size, marker, still a draft).
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$h=@file_get_contents(__DIR__.'/new.html'); if(!$h || strlen($h)<40000 || !str_contains($h,'shalimar-projects-map')) exit("ABORT bad file\n");
$n=DB::table('blog_posts')->where('id',175)->where('slug','shalimar-corp-ongoing-projects-lucknow-map-2026')->update(['content_html'=>$h,'updated_at'=>now()]);
echo "updated $n row(s), ".strlen($h)." bytes\n";
