<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AwasVikasSchemesController extends Controller
{
    /**
     * Upload awas_vikas_schemes.json to storage/app/data/ via cPanel File Manager.
     */
    private string $jsonPath;

    public function __construct()
    {
        $this->jsonPath = storage_path('app/data/awas_vikas_schemes.json');
    }

    public function index()
    {
        $schemes     = $this->loadSchemes();
        $lastUpdated = $this->getLastUpdated($schemes);
        $stats       = $this->buildStats($schemes);

        return view('pages.awas-vikas-schemes', compact('schemes', 'lastUpdated', 'stats'));
    }

    private function loadSchemes(): array
    {
        if (!file_exists($this->jsonPath)) {
            return [];
        }

        $raw = file_get_contents($this->jsonPath);

        if (!$raw) {
            return [];
        }

        $schemes = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($schemes)) {
            return [];
        }

        usort($schemes, function ($a, $b) {
            $fa = ($a['featured'] ?? false) ? 0 : 1;
            $fb = ($b['featured'] ?? false) ? 0 : 1;
            if ($fa !== $fb) return $fa - $fb;
            return ($a['sort_order'] ?? 99) - ($b['sort_order'] ?? 99);
        });

        return $schemes;
    }

    private function buildStats(array $schemes): array
    {
        $stats = ['total' => count($schemes), 'active' => 0, 'upcoming' => 0, 'completed' => 0];
        foreach ($schemes as $s) {
            match (strtolower($s['status'] ?? '')) {
                'active'    => $stats['active']++,
                'upcoming'  => $stats['upcoming']++,
                'completed' => $stats['completed']++,
                default     => null,
            };
        }
        return $stats;
    }

    private function getLastUpdated(array $schemes): string
    {
        $dates = array_filter(array_column($schemes, 'updated_on'));
        if (empty($dates)) {
            return date('d M Y');
        }
        $latest = max($dates);
        $ts = strtotime($latest);
        return $ts ? date('d M Y', $ts) : $latest;
    }
}
