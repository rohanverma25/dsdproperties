<?php

namespace App\Http\Controllers;

class ReraProjectController extends Controller
{
    /**
     * Buckets the filter buttons offer, matched against the free-text
     * `category` in the JSON ("Premium Residential", "Premium Township", …).
     * First match wins, so the order matters: "Mixed Use Township" is mixed
     * use, not residential.
     */
    private const CATEGORY_RULES = [
        'mixed-use'   => ['mixed use', 'mixed-use'],
        'commercial'  => ['commercial', 'office', 'retail', 'mall', 'sco'],
        'plotted'     => ['plot', 'plotted', 'land'],
        'residential' => ['residential', 'township', 'apartment', 'villa', 'flat'],
    ];

    /**
     * Status text in the JSON is prose, not a fixed vocabulary. Each bucket
     * carries the short label the badge shows and the CSS suffix that colours
     * it, so a long status never leaks into a pill.
     */
    private const STATUS_RULES = [
        ['needles' => ['partially ready', 'partly ready'],        'key' => 'partly-ready',        'label' => 'Partly Ready'],
        ['needles' => ['ready to move', 'possession offered'],     'key' => 'ready-to-move',       'label' => 'Ready to Move'],
        ['needles' => ['nearing possession', 'nearing completion'],'key' => 'nearing-possession',  'label' => 'Nearing Possession'],
        ['needles' => ['new launch', 'pre-launch', 'prelaunch'],   'key' => 'new-launch',          'label' => 'New Launch'],
        ['needles' => ['completed', 'delivered'],                  'key' => 'completed',           'label' => 'Completed'],
        ['needles' => ['under construction'],                      'key' => 'under-construction',  'label' => 'Under Construction'],
    ];

    /**
     * Display the RERA approved projects listing page.
     *
     * Reads project data from JSON (same pattern as LDA schemes).
     * JSON file: storage/app/data/rera-projects.json
     */
    public function index()
    {
        $jsonPath = storage_path('app/data/rera-projects.json');

        if (! file_exists($jsonPath)) {
            return view('pages.rera-approved-projects-lucknow', [
                'projects'    => [],
                'stats'       => array_fill_keys(['total', 'residential', 'commercial', 'plotted', 'mixed_use'], 0),
                'lastUpdated' => date('d M Y'),
            ]);
        }

        $projects = json_decode(file_get_contents($jsonPath), true) ?? [];

        // Derive everything the view needs here, so the cards, the filter
        // buttons and the counts can never disagree with each other.
        $projects = array_map(fn (array $p) => $p + [
            'filter_group' => $this->categoryGroup($p['category'] ?? ''),
            'status_key'   => $this->status($p['status'] ?? '')['key'],
            'status_label' => $this->status($p['status'] ?? '')['label'],
        ], $projects);

        usort($projects, fn ($a, $b) => ($a['sort_order'] ?? 99) <=> ($b['sort_order'] ?? 99));

        $groups = array_count_values(array_column($projects, 'filter_group'));

        $stats = [
            'total'       => count($projects),
            'residential' => $groups['residential'] ?? 0,
            'commercial'  => $groups['commercial'] ?? 0,
            'plotted'     => $groups['plotted'] ?? 0,
            'mixed_use'   => $groups['mixed-use'] ?? 0,
        ];

        return view('pages.rera-approved-projects-lucknow', [
            'projects'    => $projects,
            'stats'       => $stats,
            'lastUpdated' => date('d M Y', filemtime($jsonPath)),
        ]);
    }

    /** Map a free-text category onto one of the filter buttons. */
    private function categoryGroup(string $category): string
    {
        $haystack = strtolower($category);

        foreach (self::CATEGORY_RULES as $group => $needles) {
            foreach ($needles as $needle) {
                if (str_contains($haystack, $needle)) {
                    return $group;
                }
            }
        }

        return 'residential';
    }

    /** @return array{key:string,label:string} */
    private function status(string $status): array
    {
        $haystack = strtolower($status);

        foreach (self::STATUS_RULES as $rule) {
            foreach ($rule['needles'] as $needle) {
                if (str_contains($haystack, $needle)) {
                    return ['key' => $rule['key'], 'label' => $rule['label']];
                }
            }
        }

        // Unknown wording still gets a styled pill rather than bare text.
        return ['key' => 'active', 'label' => $status !== '' ? $status : 'Registered'];
    }
}
