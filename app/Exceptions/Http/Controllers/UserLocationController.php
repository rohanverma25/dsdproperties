<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLocation;
use App\Models\ValuationLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserLocationController extends Controller
{
    /**
     * 1. Main View with Filter Data
     */
    public function index()
    {
        if (request('pass') !== 'dsd26') {
            abort(403, 'Unauthorized');
        }
        // Requirement: Country selector only IN and US.
        // We look for both full names and codes to be safe.
        $targetCountries = ['India', 'IN', 'United States', 'US', 'USA'];
        
        $countries = UserLocation::select('country')
            ->distinct()
            ->whereIn('country', $targetCountries)
            ->orderBy('country')
            ->pluck('country');

        // Requirement: State only India's states.
        $regions = UserLocation::select('region')
            ->distinct()
            ->where(function($q) {
                $q->where('country', 'India')->orWhere('country', 'IN');
            })
            ->orderBy('region')
            ->pluck('region');

        // Requirement: Cities - India's famous cities AND Uttar Pradesh's all cities.
        // Defining a list of "Famous" cities (you can expand this).
        $famousCities = [
            'Mumbai', 'Delhi', 'New Delhi', 'Bangalore', 'Bengaluru', 
            'Hyderabad', 'Chennai', 'Kolkata', 'Pune', 'Jaipur', 'Ahmedabad', 'Surat'
        ];

        $cities = UserLocation::select('city')
            ->distinct()
            ->where(function($q) {
                $q->where('country', 'India')->orWhere('country', 'IN');
            })
            ->where(function($query) use ($famousCities) {
                $query->where('region', 'Uttar Pradesh')
                      ->orWhereIn('city', $famousCities);
            })
            ->orderBy('city')
            ->pluck('city');

        $valuation_leads = ValuationLog::latest()->take(50)->get();
        return view('locations.index', compact('countries', 'regions', 'cities', 'valuation_leads'));
    }

    /**
     * 2. Main DataTable API (Server-side)
     */
    public function getData(Request $request)
    {
        $query = $this->buildFilterQuery($request);

        $totalRecords = UserLocation::count();
        $filteredRecords = $query->count();

        // Sorting Logic
        // Columns indexed by DataTables
        $columns = ['id', 'ip', 'page', 'city', 'region', 'country', 'created_at'];
        
        if ($request->has('order')) {
            $columnIndex = $request->input('order.0.column');
            $columnName = $columns[$columnIndex] ?? 'created_at';
            $dir = $request->input('order.0.dir');
            $query->orderBy($columnName, $dir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        if ($length != -1) {
            $query->offset($start)->limit($length);
        }

        $data = $query->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    /**
     * 3. Chart Data API (Supports Day/Month View)
     */
    public function getChartData(Request $request)
    {
        // Apply same filters to charts so they reflect the dashboard state
        $query = $this->buildFilterQuery($request);
        
        // Clone query for location stats
        $locationQuery = clone $query;

        // --- Time Series Data ---
        $groupBy = $request->input('group_by', 'day'); // 'day' or 'month'

        if ($groupBy === 'month') {
            // Group by Month (YYYY-MM)
            $timeData = $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as date, count(*) as count")
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();
        } else {
            // Group by Day (YYYY-MM-DD)
            $timeData = $query->selectRaw("DATE(created_at) as date, count(*) as count")
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->limit(60) // Limit to last 60 days if viewing daily to avoid clutter
                ->get();
        }

        // --- Top Countries Data ---
        $countries = $locationQuery->select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'time_data' => $timeData,
            'countries' => $countries
        ]);
    }

    /**
     * 4. Date-wise Summary Table API
     * Displays data date-wise below the main table with sorting.
     */
    public function getDailySummary(Request $request)
    {
        $query = $this->buildFilterQuery($request);

        // Group by Date and Count
        $data = $query->selectRaw("DATE(created_at) as date, count(*) as total_leads")
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // We return full data here and let DataTables (client-side) handle sorting/paging 
        // for the summary table since daily rows are usually manageable (< 365/year).
        return response()->json(['data' => $data]);
    }

    /**
     * 5. URL-level Daily Stats (for heatmap grid)
     */
    public function getUrlDailyStats(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $days = min(max($days, 7), 90);

        $from = Carbon::now()->subDays($days - 1)->startOfDay();

        $rows = UserLocation::select('page', DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as visits'))
            ->where('created_at', '>=', $from)
            ->where('country', '=', 'IN')
            ->groupBy('page', 'date')
            ->orderBy('page')
            ->get();

        return response()->json($rows);
    }

    /**
     * Helper: Common Filter Logic
     */
    private function buildFilterQuery(Request $request)
    {
        $query = UserLocation::query();

        if ($request->country) {
            $query->where('country', $request->country);
        }
        if ($request->region) {
            $query->where('region', $request->region);
        }
        if ($request->city) {
            $query->where('city', $request->city);
        }

        if ($request->date_range) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                    break;
                case 'last_month':
                    $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                    break;
            }
        }
        
        // Search Logic
        if ($searchValue = $request->input('search.value')) {
             $query->where(function($q) use ($searchValue) {
                $q->where('city', 'like', "%{$searchValue}%")
                  ->orWhere('region', 'like', "%{$searchValue}%")
                  ->orWhere('country', 'like', "%{$searchValue}%")
                  ->orWhere('page', 'like', "%{$searchValue}%")
                  ->orWhere('ip', 'like', "%{$searchValue}%");
            });
        }

        return $query;
    }
}