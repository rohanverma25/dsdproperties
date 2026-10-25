<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReraProjectController extends Controller
{
    /**
     * Display the RERA approved projects listing page.
     *
     * Reads project data from JSON (same pattern as LDA schemes).
     * JSON file: storage/app/data/rera-projects.json
     */
    public function index()
    {
        // ── Load JSON data ────────────────────────────────────────
        $jsonPath = storage_path('app/data/rera-projects.json');

        if (file_exists($jsonPath)) {
            $projects = json_decode(file_get_contents($jsonPath), true) ?? [];
        } else {
            $projects = [];
        }

        // ── Sort by sort_order ────────────────────────────────────
        usort($projects, fn ($a, $b) => ($a['sort_order'] ?? 99) - ($b['sort_order'] ?? 99));

        // ── Compute stats ─────────────────────────────────────────
        $stats = [
            'total'       => count($projects),
            'residential' => collect($projects)->where('category', 'Residential')->count(),
            'commercial'  => collect($projects)->where('category', 'Commercial')->count(),
            'plotted'     => collect($projects)->where('category', 'Plotted')->count(),
            'mixed_use'   => collect($projects)->where('category', 'Mixed Use')->count(),
        ];

        // ── Last updated date ─────────────────────────────────────
        $lastUpdated = date('d M Y', filemtime($jsonPath));

        return view('pages.rera-approved-projects-lucknow', compact(
            'projects',
            'stats',
            'lastUpdated'
        ));
    }
}