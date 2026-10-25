<?php

namespace App\Services;

use App\Models\VerificationReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VerificationPdfService
{
    public function generate(VerificationReport $report): string
    {
        // Ensure font cache directory exists
        $fontCacheDir = storage_path('fonts');
        if (! is_dir($fontCacheDir)) {
            mkdir($fontCacheDir, 0755, true);
        }

        // Ensure reports directory exists
        $reportsDir = storage_path('app/private/reports');
        if (! is_dir($reportsDir)) {
            mkdir($reportsDir, 0755, true);
        }

        $report->loadMissing(['findings', 'evidences']);

        $checks   = config('verification_checks');
        $findings = $report->findings->keyBy('check_slug');
        $evidences = $report->evidences;

        $data = [
            'report'   => $report,
            'checks'   => $checks,
            'findings' => $findings,
            'evidences'=> $evidences,
            'fontPath' => public_path('fonts'),
            'logoPath' => public_path('images/logo.webp'),
        ];

        $pdf = Pdf::loadView('pdf.verification.report', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled'   => true,
                'isRemoteEnabled'        => false,
                'isFontSubsettingEnabled'=> true,
                'defaultFont'            => 'sans-serif',
                'dpi'                    => 150,
                'fontDir'                => public_path('fonts'),
                'fontCache'              => storage_path('fonts'),
                'logOutputFile'          => storage_path('logs/dompdf.log'),
                'chroot'                 => base_path(),
            ]);

        $filename   = $report->report_id . '.pdf';
        $storagePath = 'private/reports/' . $filename;

        Storage::disk('local')->put($storagePath, $pdf->output());

        $report->update([
            'pdf_path' => $storagePath,
            'status'   => 'ready_to_deliver',
        ]);

        return $storagePath;
    }

    public function fontsReady(): bool
    {
        return file_exists(public_path('fonts/NotoSansDevanagari-Regular.ttf'))
            && file_exists(public_path('fonts/NotoSansDevanagari-Bold.ttf'));
    }

    public function downloadFonts(): array
    {
        $fontDir = public_path('fonts');
        if (! is_dir($fontDir)) {
            mkdir($fontDir, 0755, true);
        }

        $fonts = [
            'NotoSansDevanagari-Regular.ttf' => 'https://github.com/googlefonts/noto-fonts/raw/main/hinted/ttf/NotoSansDevanagari/NotoSansDevanagari-Regular.ttf',
            'NotoSansDevanagari-Bold.ttf'    => 'https://github.com/googlefonts/noto-fonts/raw/main/hinted/ttf/NotoSansDevanagari/NotoSansDevanagari-Bold.ttf',
        ];

        $results = [];
        foreach ($fonts as $filename => $url) {
            $dest = $fontDir . '/' . $filename;
            if (file_exists($dest)) {
                $results[$filename] = 'already_exists';
                continue;
            }
            try {
                $client   = new \GuzzleHttp\Client(['timeout' => 60, 'verify' => false]);
                $response = $client->get($url);
                file_put_contents($dest, $response->getBody()->getContents());
                $results[$filename] = 'downloaded';
            } catch (\Exception $e) {
                Log::error("Font download failed: {$filename} — " . $e->getMessage());
                $results[$filename] = 'failed: ' . $e->getMessage();
            }
        }

        // Clear DomPDF font cache so it picks up new fonts
        $cacheFile = storage_path('fonts/dompdf_font_family_cache.php');
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        return $results;
    }
}
