<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LdaGis;
use App\Services\LdaGisUnavailable;
use Illuminate\Http\Request;

/**
 * LDA Plot Check: internal tool for the verification team (behind the ver.admin login), built 17 Nov 2026.
 * Looks up a plot number or a map point in LDA's public GIS, live (see App\Services\LdaGis for the rules).
 * Not public: LDA's terms need written permission before their data is shown on our public site.
 */
class LdaPlotCheckController extends Controller
{
    public function index(LdaGis $gis)
    {
        try {
            $sectors = $gis->sectors();
            $gisDown = false;
        } catch (\Throwable $e) {
            $sectors = [];
            $gisDown = true;
        }

        return view('admin.verifications.lda-plot-check', compact('sectors', 'gisDown'));
    }

    public function lookup(Request $request, LdaGis $gis)
    {
        $data = $request->validate([
            'mode' => 'required|in:point,plot,link',
            'lat' => 'required_if:mode,point|nullable|numeric',
            'lng' => 'required_if:mode,point|nullable|numeric',
            'scheme' => 'required_if:mode,plot|nullable|string|max:80',
            'sector' => 'required_if:mode,plot|nullable|string|max:80',
            'plot' => 'required_if:mode,plot|nullable|string|max:30',
            'link' => 'required_if:mode,link|nullable|string|max:2000',
        ]);

        try {
            if ($data['mode'] === 'plot') {
                $r = $gis->findPlot($data['scheme'], $data['sector'], $data['plot']);
                if (!$r) return response()->json(['error' => 'No plot "' . $data['plot'] . '" found in ' . $data['sector'] . ' in LDA GIS. Check the number, or pick the spot on the map instead.'], 404);
                return response()->json($r);
            }

            if ($data['mode'] === 'link') {
                $c = $gis->parseLocation($data['link']);
                if (!$c) return response()->json(['error' => 'Could not read a location from that. Paste a Google Maps link, or coordinates like 26.8560, 80.9930.'], 422);
                [$lat, $lng] = [$c['lat'], $c['lng']];
            } else {
                [$lat, $lng] = [(float)$data['lat'], (float)$data['lng']];
            }

            if (!$gis->inLucknow($lat, $lng)) return response()->json(['error' => 'That location is outside Lucknow district. LDA GIS only covers Lucknow.'], 422);

            return response()->json($gis->pointReport($lat, $lng));
        } catch (LdaGisUnavailable | \Illuminate\Http\Client\ConnectionException $e) {
            return response()->json(['error' => 'LDA\'s GIS server is not answering right now. Please try again in a few minutes.'], 503);
        }
    }
}
