<?php

namespace App\Services;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Live lookups against LDA's public GIS (gis.ldalucknow.in, ArcGIS Server REST), for the internal
 * LDA Plot Check tool (/admin/verifications/lda-plot-check). Built 17 Nov 2026.
 *
 * Rules (LDA terms of use, clause 5; memory lda-official-data-sources):
 *  - NOTHING is copied into our database. Each lookup asks LDA live; the answer is cached for a few minutes only,
 *    so repeat clicks don't hit LDA's server. Only the scheme/sector name list is cached for a day.
 *  - Internal use until LDA gives written permission for a public tool.
 *  - The GIS is a reference, not legal proof of title; the view says so on every result.
 */
class LdaGis
{
    const BASE = 'https://gis.ldalucknow.in/server/rest/services';
    const PLOTS = 'LDAGIS/Sector_Layout/MapServer/1';
    const MASTERPLAN = 'LML_Proposed_Masterplan/MapServer/0';
    const EXISTING = 'LMB_Existing_All_Layer/MapServer/0';
    const VILLAGES = 'LDAGIS/Administrative_Boundary/MapServer/3';
    const TOD = 'LDAGIS/Administrative_Boundary/MapServer/2';
    const ENG_ZONE = 'LDAGIS/Administrative_Boundary/MapServer/1';
    const MUNICIPAL = 'LDAGIS/Administrative_Boundary/MapServer/4';
    const LDA_AREA = 'LDAGIS/Administrative_Boundary/MapServer/0';

    const PLOT_FIELDS = 'objectid,scheme,sub_scheme,sector,block,plot_no,property_size,plot_size,property_type,landuse_type,'
        . 'landuse_subtype,allotment_status,pid,unique_code,zone,road_width,latitude,longitude';

    // Lucknow district, roughly. Anything outside is rejected before we ask LDA.
    const BOUNDS = ['lat' => [26.55, 27.20], 'lng' => [80.55, 81.35]];

    /** Proposed master plan (LML) categories, judged for someone buying a residential plot. */
    const MP_RED = ['Green Belt', 'River / Nala / Reservoir', 'Water Body', 'Forest', 'Environmental Park / Forest',
        'Park and Open Spaces', 'Botanical Garden / Park', 'Regional Park and Sport Complex', 'Dam', 'Prohibited Area',
        'Cremation Grounds / Burial Ground', 'Revenue Pond Road', 'Sewerage / S.T.P.', 'Solid Waste Disposal Center',
        'Slaughter House', 'Airstrip', 'Zoo/Museum'];
    const MP_GREEN = ['Residential', 'Builtup Area', 'Rural Abadi', 'Mixed land use 1', 'Mixed land use 2'];

    /** Existing land use (LMB) classes that rule out a private plot. */
    const EX_RED = ['Water Bodies', 'Wetlands', 'Eco-Sensitive Areas', 'Green Areas', 'Railway Property',
        'Central Govt. Property', 'State Govt. Property', 'Road', 'Lake', 'Expressway', 'Heritage', 'Solid Waste Management'];

    /** Plot-layer land use types that are not a buildable private plot. */
    const PLOT_RED = ['Recreational Green', 'Water Body', 'Transportation', 'Public Utilities'];

    // ------------------------------------------------------------------ public API

    /** Everything we know about one point. */
    public function pointReport(float $lat, float $lng): array
    {
        $this->assertInLucknow($lat, $lng);
        $key = 'ldagis:pt:' . round($lat, 6) . ',' . round($lng, 6);

        return Cache::remember($key, now()->addMinutes(10), function () use ($lat, $lng) {
            $pt = ['geometry' => "$lng,$lat", 'geometryType' => 'esriGeometryPoint', 'inSR' => 4326,
                'spatialRel' => 'esriSpatialRelIntersects', 'returnGeometry' => 'false', 'f' => 'json'];

            $r = Http::pool(fn (Pool $p) => [
                // array_merge (not +) so returnGeometry=true overrides the default 'false' in $pt
                $p->as('plot')->timeout(15)->get($this->url(self::PLOTS), array_merge($pt, ['outFields' => self::PLOT_FIELDS,
                    'returnGeometry' => 'true', 'outSR' => 4326])),
                $p->as('near')->timeout(15)->get($this->url(self::PLOTS), array_merge($pt, ['outFields' => self::PLOT_FIELDS,
                    'distance' => 30, 'units' => 'esriSRUnit_Meter', 'returnGeometry' => 'true', 'outSR' => 4326])),
                $p->as('mp')->timeout(15)->get($this->url(self::MASTERPLAN), $pt + ['outFields' => 'type']),
                $p->as('ex')->timeout(15)->get($this->url(self::EXISTING), $pt + ['outFields' => 'class,sub_class']),
                $p->as('village')->timeout(15)->get($this->url(self::VILLAGES), $pt + ['outFields' => 'village_na,village_hindi,tehsil']),
                $p->as('tod')->timeout(15)->get($this->url(self::TOD), $pt + ['outFields' => 'objectid']),
                $p->as('zone')->timeout(15)->get($this->url(self::ENG_ZONE), $pt + ['outFields' => 'zone_name']),
                $p->as('muni')->timeout(15)->get($this->url(self::MUNICIPAL), $pt + ['outFields' => 'objectid']),
                $p->as('lda')->timeout(15)->get($this->url(self::LDA_AREA), $pt + ['outFields' => 'objectid']),
            ]);

            $f = []; $failed = [];
            foreach ($r as $name => $resp) {
                $ok = $resp instanceof \Illuminate\Http\Client\Response && $resp->ok() && !isset($resp->json()['error']);
                if (!$ok) { $failed[] = $name; $f[$name] = []; continue; }
                $f[$name] = $resp->json()['features'] ?? [];
            }
            if (count($failed) === count($r)) throw new LdaGisUnavailable('LDA GIS did not answer');

            $plot = isset($f['plot'][0]) ? $this->plot($f['plot'][0]) : null;
            $near = array_values(array_filter(array_map(fn ($x) => $this->plot($x), $f['near']),
                fn ($p) => !$plot || $p['objectid'] !== $plot['objectid']));

            $mp = array_values(array_unique(array_filter(array_map(fn ($x) => trim((string)($x['attributes']['type'] ?? '')), $f['mp']))));
            $ex = array_values(array_unique(array_filter(array_map(fn ($x) => trim(implode(' — ', array_filter([
                $x['attributes']['class'] ?? null, $x['attributes']['sub_class'] ?? null]))), $f['ex']))));
            $v = $f['village'][0]['attributes'] ?? null;

            $report = [
                'lat' => $lat, 'lng' => $lng,
                'plot' => $plot,
                'nearby' => array_slice($near, 0, 12),
                'masterplan' => $mp,
                'existing' => $ex,
                'village' => $v ? ['en' => $v['village_na'] ?? null, 'hi' => $v['village_hindi'] ?? null, 'tehsil' => $v['tehsil'] ?? null] : null,
                'tod' => !empty($f['tod']),
                'zone' => $f['zone'][0]['attributes']['zone_name'] ?? null,
                'municipal' => !empty($f['muni']),
                'in_lda_area' => !empty($f['lda']),
                'failed_layers' => $failed,
                'checked_at' => now()->format('d M Y, H:i'),
            ];
            $report['flags'] = $this->flags($report);
            $report['verdict'] = $this->verdict($report['flags']);

            return $report;
        });
    }

    /** Find a plot by scheme + sector + plot number, then report on its location. */
    public function findPlot(string $scheme, string $sector, string $plotNo): ?array
    {
        $plotNo = strtoupper(trim(preg_replace('/\s+/', '', $plotNo)));
        if ($plotNo === '' || !preg_match('~^[A-Z0-9/\-.()]{1,30}$~', $plotNo)) return null;
        $q = fn ($v) => str_replace("'", "''", $v);
        $base = "scheme='{$q($scheme)}' AND sector='{$q($sector)}'";

        // Exact plot number first; if nothing, numbers that end with what was typed (e.g. "174" finds "2/174").
        foreach (["UPPER(plot_no)='{$q($plotNo)}'", "UPPER(plot_no) LIKE '%{$q($plotNo)}'"] as $cond) {
            $resp = Http::timeout(15)->get($this->url(self::PLOTS), ['where' => "$base AND $cond",
                'outFields' => self::PLOT_FIELDS, 'returnGeometry' => 'false', 'resultRecordCount' => 10, 'f' => 'json']);
            if (!$resp->ok() || isset($resp->json()['error'])) throw new LdaGisUnavailable('LDA GIS did not answer');
            $hits = $resp->json()['features'] ?? [];
            if (count($hits) > 1) return ['choices' => array_map(fn ($h) => $this->plot($h), $hits)];
            if (count($hits) === 1) {
                $a = $hits[0]['attributes'];
                if (empty($a['latitude']) || empty($a['longitude'])) return ['plot' => $this->plot($hits[0]), 'no_location' => true];
                return $this->pointReport((float)$a['latitude'], (float)$a['longitude']);
            }
        }
        return null;
    }

    /** Scheme → sub-scheme → sector names, from LDA's own records (names only, cached a day). */
    public function sectors(): array
    {
        return Cache::remember('ldagis:sectors:v1', now()->addDay(), function () {
            $resp = Http::timeout(20)->get($this->url(self::PLOTS), ['where' => "scheme IS NOT NULL AND sector IS NOT NULL",
                'groupByFieldsForStatistics' => 'scheme,sub_scheme,sector',
                'outStatistics' => json_encode([['statisticType' => 'count', 'onStatisticField' => 'objectid', 'outStatisticFieldName' => 'n']]),
                'f' => 'json']);
            if (!$resp->ok() || isset($resp->json()['error'])) throw new LdaGisUnavailable('LDA GIS did not answer');
            $out = [];
            foreach ($resp->json()['features'] ?? [] as $x) {
                $a = $x['attributes'];
                $out[$a['scheme']][] = ['sector' => $a['sector'], 'sub' => $a['sub_scheme'], 'n' => $a['n'],
                    'label' => trim(preg_replace('/\s+/', ' ', $a['sector'])) . ($a['sub_scheme'] ? ' (' . trim($a['sub_scheme']) . ')' : '')];
            }
            ksort($out);
            foreach ($out as &$list) usort($list, fn ($a, $b) => strnatcasecmp($a['label'], $b['label']));
            return $out;
        });
    }

    /**
     * Pull coordinates out of whatever the user pasted: "26.85, 80.99", a google.com/maps link (@lat,lng / q= / !3d!4d),
     * or a maps.app.goo.gl short link (followed only across Google hosts, to avoid fetching arbitrary URLs).
     */
    public function parseLocation(string $text): ?array
    {
        $text = trim($text);
        if ($c = $this->coordsIn($text)) return $c;
        if (!preg_match('~https?://\S+~i', $text, $m)) return null;

        $url = $m[0];
        for ($hop = 0; $hop < 5; $hop++) {
            $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
            if (!preg_match('~(^|\.)(google\.[a-z.]+|goo\.gl|app\.goo\.gl)$~', $host)) return null;
            if ($c = $this->coordsIn(urldecode($url))) return $c;
            $resp = Http::timeout(10)->withoutRedirecting()->withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($url);
            $next = $resp->header('Location');
            if (!$next) return $this->coordsIn(urldecode($resp->body()));
            $url = $next;
        }
        return null;
    }

    // ------------------------------------------------------------------ helpers

    private function coordsIn(string $s): ?array
    {
        $pats = ['~!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)~', '~@(-?\d+\.\d+),(-?\d+\.\d+)~',
            '~[?&](?:q|query|ll|destination|center)=(-?\d+\.\d+)(?:,|%2C)\s*(-?\d+\.\d+)~i', '~^\s*(-?\d{1,2}\.\d+)\s*[, ]\s*(-?\d{1,3}\.\d+)\s*$~'];
        foreach ($pats as $p) {
            if (preg_match($p, $s, $m)) {
                [$lat, $lng] = [(float)$m[1], (float)$m[2]];
                if ($lat > 60 && $lng < 60) [$lat, $lng] = [$lng, $lat]; // pasted as lng,lat
                return ['lat' => $lat, 'lng' => $lng];
            }
        }
        return null;
    }

    public function inLucknow(float $lat, float $lng): bool
    {
        return $lat >= self::BOUNDS['lat'][0] && $lat <= self::BOUNDS['lat'][1]
            && $lng >= self::BOUNDS['lng'][0] && $lng <= self::BOUNDS['lng'][1];
    }

    private function assertInLucknow(float $lat, float $lng): void
    {
        if (!$this->inLucknow($lat, $lng)) throw new \InvalidArgumentException('outside');
    }

    private function url(string $layer): string
    {
        return self::BASE . '/' . $layer . '/query';
    }

    private function plot(array $feature): array
    {
        $a = $feature['attributes'];
        $size = trim((string)($a['property_size'] ?? ''));
        if (preg_match('~^0(\.0+)?\s*(sqm)?$~i', $size)) $size = '';
        $rings = $feature['geometry']['rings'] ?? null;

        return [
            'objectid' => $a['objectid'] ?? null,
            'scheme' => trim((string)($a['scheme'] ?? '')) ?: null,
            'sub_scheme' => trim((string)($a['sub_scheme'] ?? '')) ?: null,
            'sector' => trim(preg_replace('/\s+/', ' ', (string)($a['sector'] ?? ''))) ?: null,
            'plot_no' => ($p = trim((string)($a['plot_no'] ?? ''))) !== '' && strtoupper($p) !== 'N.A' ? $p : null,
            'size' => $size ?: null,
            'dimensions' => trim((string)($a['plot_size'] ?? '')) ?: null,
            'type' => trim((string)($a['property_type'] ?? '')) ?: null,
            'landuse' => trim((string)($a['landuse_type'] ?? '')) ?: null,
            'landuse_sub' => trim((string)($a['landuse_subtype'] ?? '')) ?: null,
            'allotment' => trim((string)($a['allotment_status'] ?? '')) ?: null,
            'pid' => trim((string)($a['pid'] ?? '')) ?: null,
            'code' => trim((string)($a['unique_code'] ?? '')) ?: null,
            'zone' => trim((string)($a['zone'] ?? '')) ?: null,
            'road_width' => trim((string)($a['road_width'] ?? '')) ?: null,
            'lat' => isset($a['latitude']) ? (float)$a['latitude'] : null,
            'lng' => isset($a['longitude']) ? (float)$a['longitude'] : null,
            // [[lng,lat],...] rings straight from LDA (outSR 4326), drawn as-is on the map
            'rings' => $rings,
        ];
    }

    /** Each flag: [level red|amber|green|info, text]. Worded as "LDA's record shows", never as a legal finding. */
    private function flags(array $r): array
    {
        $f = [];
        if (!$r['in_lda_area']) $f[] = ['amber', 'This point is outside the LDA development area boundary in LDA GIS.'];

        foreach ($r['masterplan'] as $t) {
            if (in_array($t, self::MP_RED, true)) $f[] = ['red', "LDA master plan marks this spot as \"$t\". Private residential building is normally not allowed in this category."];
            elseif (in_array($t, self::MP_GREEN, true)) $f[] = ['green', "LDA master plan land use here: \"$t\"."];
            elseif ($t === 'NIL' || $t === 'Undefined Area' || $t === 'RL') $f[] = ['amber', "LDA master plan category here is \"$t\" (not defined). Check the land use before buying."];
            else $f[] = ['amber', "LDA master plan land use here is \"$t\", not residential. Check what is permitted before buying a house plot."];
        }
        if (!$r['masterplan']) $f[] = ['amber', 'No master plan category found for this exact point in LDA GIS.'];

        foreach ($r['existing'] as $t) {
            $cls = trim(explode(' — ', $t)[0]);
            if (in_array($cls, self::EX_RED, true)) $f[] = ['red', "LDA's existing land-use survey records this spot as \"$t\"."];
        }

        $p = $r['plot'];
        if ($p) {
            if (in_array($p['landuse'], self::PLOT_RED, true))
                $f[] = ['red', "In LDA's sector layout this spot is \"" . ($p['landuse_sub'] ?: $p['landuse']) . "\", not a private plot."];
            if ($p['allotment'] === 'Vacant')
                $f[] = ['amber', 'LDA GIS shows this plot as "Vacant" (not allotted). If someone is selling it as theirs, ask for the LDA allotment letter and registry.'];
            if (!$p['size'] && $p['plot_no']) $f[] = ['info', 'LDA GIS has no size recorded for this plot.'];
        } else {
            $f[] = ['amber', 'No LDA plot record at this exact point. It may be outside LDA layouts (private colony or village land) or in a scheme not yet in LDA GIS. Check the khatauni and layout approval.'];
        }
        if ($r['tod']) $f[] = ['info', 'Inside the Metro TOD zone (about 500 m around the metro corridor), where different building rules apply.'];
        if ($r['failed_layers']) $f[] = ['info', 'Some LDA layers did not answer (' . implode(', ', $r['failed_layers']) . '). Try again for a complete check.'];

        return $f;
    }

    private function verdict(array $flags): string
    {
        $levels = array_column($flags, 0);
        return in_array('red', $levels, true) ? 'red' : (in_array('amber', $levels, true) ? 'amber' : 'green');
    }
}
