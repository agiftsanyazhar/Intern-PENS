<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Customer, OpportunityState, User};
use Carbon\Carbon;

class HomeController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index()
    {
        // Fetching total customers, users, and opportunities
        $totalCustomers = Customer::count();
        $totalUsers = User::count();
        $totalOpportunities = OpportunityState::count();

        // Fetching opportunity data
        $opportunityGood = OpportunityState::where('health_id', '1')->count();
        $opportunityFair = OpportunityState::where('health_id', '2')->count();
        $opportunityPoor = OpportunityState::where('health_id', '3')->count();
        $opportunityCritical = OpportunityState::where('health_id', '4')->count();
        $opportunityCompleted = OpportunityState::where('opportunity_status_id', '4')->count();
        $opportunityFailed = OpportunityState::where('opportunity_status_id', '5')->count();
        $opportunityGrossValue = OpportunityState::sum('opportunity_value');

        $assets = ['chart', 'animation'];

        $tenRecentOpportunities = $this->getRecentActivity()[0];
        $percentageOfTenRecentOpportunities = $this->getRecentActivity()[1]['percentage'];

        return view('dashboards.dashboard', compact(
            'assets',
            'totalCustomers',
            'totalUsers',
            'totalOpportunities',
            'opportunityGood',
            'opportunityFair',
            'opportunityPoor',
            'opportunityCritical',
            'opportunityCompleted',
            'opportunityFailed',
            'opportunityGrossValue',
            'tenRecentOpportunities',
            'percentageOfTenRecentOpportunities'
        ));
    }

    public function earning(Request $request)
    {
        $config = $this->filterConfig($request);

        // Only apply date range filtering if the filter is NOT 'all_time'
        $baseQuery = OpportunityState::query();
        if ($config[0] !== 'all_time') {
            $baseQuery = $baseQuery->whereBetween('created_at', [$config[1], $config[2]]);
        }

        // Total earnings (no status filter)
        $totalEarnings = $baseQuery->clone()
            ->selectRaw(
                match ($config[0]) {
                    'last_24_hours' => "DATE_FORMAT(created_at, '%H:%i') as formatted_date, SUM(opportunity_value) as value",
                    'last_7_days' => "DATE_FORMAT(created_at, '%a') as formatted_date, SUM(opportunity_value) as value",
                    'last_30_days', 'last_60_days', 'last_90_days' => "DATE_FORMAT(created_at, '%d %b') as formatted_date, SUM(opportunity_value) as value",
                    default => "DATE_FORMAT(created_at, '%Y/%m/%d') as formatted_date, SUM(opportunity_value) as value",
                }
            )
            ->orderBy('formatted_date')
            ->groupBy('formatted_date')
            ->pluck('value', 'formatted_date');

        // Completed earnings
        $completedEarnings = $baseQuery->clone()
            ->where('opportunity_status_id', 4)
            ->selectRaw("DATE_FORMAT(created_at, '%d %b') as formatted_date, SUM(opportunity_value) as value")
            ->orderBy('formatted_date')
            ->groupBy('formatted_date')
            ->pluck('value', 'formatted_date');

        // Failed earnings
        $failedEarnings = $baseQuery->clone()
            ->where('opportunity_status_id', 5)
            ->selectRaw("DATE_FORMAT(created_at, '%d %b') as formatted_date, SUM(opportunity_value) as value")
            ->orderBy('formatted_date')
            ->groupBy('formatted_date')
            ->pluck('value', 'formatted_date');

        if ($request->ajax()) {
            return response()->json([
                'totalEarnings' => $totalEarnings,
                'completedEarnings' => $completedEarnings,
                'failedEarnings' => $failedEarnings,
            ]);
        }
    }

    public function getPerformanceMetrics(Request $request)
    {
        $filter = $request->query('filter');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        switch ($filter) {
            case 'yoy':
                $yoy = $this->calculateYoY();
                return response()->json(['yoy' => $yoy]);
            case 'ytd':
                $ytd = $this->calculateYTD();
                return response()->json(['ytd' => $ytd]);
            case 'qoq':
                $qoq = $this->calculateQoQ();
                return response()->json(['qoq' => $qoq]);
            case 'mom':
                $mom = $this->calculateMoM();
                return response()->json(['mom' => $mom]);
            default:
                return response()->json(['error' => 'Invalid filter']);
        }
    }

    public function getOpportunitiesCustomers(Request $request)
    {
        $config = $this->filterConfig($request);

        // Fetch data based on the time range
        $opportunityQuery = OpportunityState::query();
        $customerQuery = Customer::query();

        // Only apply date range filtering if the filter is NOT 'all_time'
        if ($config[0] !== 'all_time') {
            $opportunityQuery = $opportunityQuery->whereBetween('created_at', [$config[1], $config[2]]);
            $customerQuery = $customerQuery->whereBetween('created_at', [$config[1], $config[2]]);
        }

        // Calculate totals
        $newOpportunities = $opportunityQuery->count();
        $newCustomers = $customerQuery->count();

        if ($request->ajax()) {
            return response()->json([
                'new_opportunities' => $newOpportunities,
                'new_customers' => $newCustomers,
            ]);
        }
    }

    public function earningOverview(Request $request)
    {
        $config = $this->filterConfig(request());

        $baseQuery = OpportunityState::query();
        if ($config[0] !== 'all_time') {
            $baseQuery = $baseQuery->whereBetween('created_at', [$config[1], $config[2]]);
        }

        // Calculate earnings for each status
        $totalEarnings = $baseQuery->clone()->sum("opportunity_value");
        $inquiryEarnings = $baseQuery->clone()->where('opportunity_status_id', 1)->sum("opportunity_value");
        $followUpEarnings = $baseQuery->clone()->where('opportunity_status_id', 2)->sum("opportunity_value");
        $staledEarnings = $baseQuery->clone()->where('opportunity_status_id', 3)->sum("opportunity_value");
        $completedEarnings = $baseQuery->clone()->where('opportunity_status_id', 4)->sum("opportunity_value");
        $failedEarnings = $baseQuery->clone()->where('opportunity_status_id', 5)->sum("opportunity_value");

        // Calculate percentages
        $inquiryPercentage = $totalEarnings ? ($inquiryEarnings / $totalEarnings) * 100 : 0;
        $followUpPercentage = $totalEarnings ? ($followUpEarnings / $totalEarnings) * 100 : 0;
        $staledPercentage = $totalEarnings ? ($staledEarnings / $totalEarnings) * 100 : 0;
        $completedPercentage = $totalEarnings ? ($completedEarnings / $totalEarnings) * 100 : 0;
        $failedPercentage = $totalEarnings ? ($failedEarnings / $totalEarnings) * 100 : 0;

        if ($request->ajax()) {
            return response()->json([
                'totalEarnings' => $totalEarnings,
                'inquiryEarnings' => $inquiryEarnings,
                'followUpEarnings' => $followUpEarnings,
                'staledEarnings' => $staledEarnings,
                'completedEarnings' => $completedEarnings,
                'failedEarnings' => $failedEarnings,
                'inquiryPercentage' => $inquiryPercentage,
                'followUpPercentage' => $followUpPercentage,
                'staledPercentage' => $staledPercentage,
                'completedPercentage' => $completedPercentage,
                'failedPercentage' => $failedPercentage,
            ]);
        }
    }

    private function filterConfig($request)
    {
        $filter = $request->input('filter', 'last_24_hours');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $endDate = now();
        $startDate = match ($filter) {
            'last_24_hours' => $endDate->copy()->subDay()->startOfDay(),
            'last_7_days' => $endDate->copy()->subDays(7),
            'last_30_days' => $endDate->copy()->subDays(30),
            'last_60_days' => $endDate->copy()->subDays(60),
            'last_90_days' => $endDate->copy()->subDays(90),
            'all_time' => null,
            'custom' => $startDate ? Carbon::parse($startDate) : null,
            default => $endDate->copy()->subDay()->startOfDay(),
        };

        // Handle custom date range for 'custom' filter
        if ($filter === 'custom' && $endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        return [$filter, $startDate, $endDate];
    }

    private function getRecentActivity()
    {
        $percentage = $this->calculateMoM();

        $recentActivity = OpportunityState::orderBy('created_at', 'desc')->limit(10)->get();

        return [$recentActivity, $percentage];
    }

    private function calculateYoY()
    {
        $currentYear = now()->year;
        $previousYear = $currentYear - 1;

        // Calculate total for the current year
        $currentYearPerformance = OpportunityState::whereYear('created_at', $currentYear)
            ->sum('opportunity_value');

        // Calculate total for the previous year
        $previousYearPerformance = OpportunityState::whereYear('created_at', $previousYear)
            ->sum('opportunity_value');

        // Calculate YoY percentage
        if ($previousYearPerformance > 0) {
            $yoyPercentage = (($currentYearPerformance - $previousYearPerformance) / $previousYearPerformance) * 100;
        } else {
            $yoyPercentage = 0;
        }

        return [
            'percentage' => number_format($yoyPercentage, 2, ',', '.'),
            'current_value' => $currentYearPerformance,
            'previous_value' => $previousYearPerformance,
        ];
    }

    private function calculateYTD()
    {
        $currentYear = now()->year;
        $startOfCurrentYear = Carbon::create($currentYear, 1, 1);

        $previousYear = $currentYear - 1;
        $startOfPreviousYear = Carbon::create($previousYear, 1, 1);
        $endOfPreviousYear = Carbon::create($previousYear, now()->month, now()->day);

        // Calculate YTD for current year
        $currentPerformance = OpportunityState::whereBetween('created_at', [$startOfCurrentYear, now()])
            ->sum('opportunity_value');

        // Calculate YTD for previous year
        $previousPerformance = OpportunityState::whereBetween('created_at', [$startOfPreviousYear, $endOfPreviousYear])
            ->sum('opportunity_value');

        if ($previousPerformance > 0) {
            $ytdPercentage = (($currentPerformance - $previousPerformance) / $previousPerformance) * 100;
        } else {
            $ytdPercentage = 0;
        }

        return [
            'percentage' => number_format($ytdPercentage, 2, ',', '.'),
            'current_value' => $currentPerformance,
            'previous_value' => $previousPerformance,
        ];
    }

    private function calculateQoQ()
    {
        $currentQuarter = Carbon::now()->quarter;
        $currentYear = Carbon::now()->year;

        // Set the current quarter start and end
        $currentQuarterStart = Carbon::create($currentYear)->setQuarter($currentQuarter)->startOfQuarter();
        $currentQuarterEnd = Carbon::create($currentYear)->setQuarter($currentQuarter)->endOfQuarter();

        // Get the previous quarter start and end
        $previousQuarterStart = $currentQuarterStart->copy()->subMonths(3);
        $previousQuarterEnd = $currentQuarterEnd->copy()->subMonths(3);

        // Calculate performance for current and previous quarters
        $currentQuarterPerformance = OpportunityState::whereBetween('created_at', [$currentQuarterStart, $currentQuarterEnd])
            ->sum('opportunity_value');

        $previousQuarterPerformance = OpportunityState::whereBetween('created_at', [$previousQuarterStart, $previousQuarterEnd])
            ->sum('opportunity_value');

        // Calculate QoQ percentage
        if ($previousQuarterPerformance > 0) {
            $qoqPercentage = (($currentQuarterPerformance - $previousQuarterPerformance) / $previousQuarterPerformance) * 100;
        } else {
            $qoqPercentage = 0;
        }

        return [
            'percentage' => number_format($qoqPercentage, 2, ',', '.'),
            'current_value' => $currentQuarterPerformance,
            'previous_value' => $previousQuarterPerformance
        ];
    }

    private function calculateMoM()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $currentMonthStart = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $currentMonthEnd = Carbon::create(
            $currentYear,
            $currentMonth,
            1
        )->endOfMonth();

        $previousMonthStart = $currentMonthStart->copy()->subMonth();
        $previousMonthEnd = $currentMonthEnd->copy()->subMonth();

        $currentMonthPerformance = OpportunityState::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('opportunity_value');

        $previousMonthPerformance = OpportunityState::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('opportunity_value');

        if ($previousMonthPerformance > 0) {
            $momPercentage = (($currentMonthPerformance - $previousMonthPerformance) / $previousMonthPerformance) * 100;
        } else {
            $momPercentage = 0;
        }

        return [
            'percentage' => number_format($momPercentage, 2, ',', '.'),
            'current_value' => $currentMonthPerformance,
            'previous_value' => $previousMonthPerformance
        ];
    }
}
