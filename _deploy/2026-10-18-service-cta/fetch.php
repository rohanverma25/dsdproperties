<?php
require __DIR__.'/../../vendor/autoload.php'; $app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$slugs = ['property-transfer-after-death-lucknow-hindi-2026','transfer-property-after-death-lucknow-guide','dhara-80-krishi-bhumi-aawasiya-hindi-lucknow-2026','dhara-80-naksha-zila-panchayat-hindi-lucknow-2026','dakhil-kharij-lucknow-mutation-process-guide-hindi','dakhil-kharij-lucknow-mutation-process-guide','check-property-ownership-records-lucknow','lda-illegal-colony-list-lucknow-2026','LDA-illegal-colony-list-lucknow-2026-verification-hindi','transforming-agricultural-land-residential-property-lucknow','how-to-check-lda-approved-map-lucknow-2026','lda-online-property-verification-lucknow-2026','lda-vs-zila-panchayat-lucknow-comparison','lda-vs-zila-panchayat-lucknow-hindi','zila-panchayat-building-byelaws-2026-hindi-lucknow-2026','stamp-duty-registration-charges-lucknow-2026','rera-zila-panchayat-rural-plots-hindi-lucknow-2026'];
foreach ($slugs as $s) {
  $p = DB::table('blog_posts')->where('slug',$s)->first(['id','slug','title','content_html']);
  if (!$p) { echo "MISSING $s\n"; continue; }
  file_put_contents(__DIR__."/{$p->id}.before.html", $p->content_html);
  $h=$p->content_html;
  printf("%d|%s|len=%d|keyfacts=%d|verify=%d|cbtn=%d|svclink=%d|%s\n",$p->id,$s,strlen($h),substr_count($h,'class="dsd-key-facts"'),substr_count($h,'verify-cta'),substr_count($h,'{{CONSULTATION_BUTTON'),substr_count($h,'/services/property-verification'),mb_substr($p->title,0,50));
}
