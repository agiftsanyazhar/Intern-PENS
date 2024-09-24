<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Customer, OpportunityState};
use App\Models\User;
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
        // $opportunityCompletedValue = OpportunityState::where('opportunity_status_id', '4')->sum('opportunity_value');
        // $opportunityFailedValue = OpportunityState::where('opportunity_status_id', '5')->sum('opportunity_value');

        $assets = ['chart', 'animation'];

        // Pass the data to the view for initial page load
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
            // 'opportunityCompletedValue',
            // 'opportunityFailedValue',
        ));
    }

    public function earning(Request $request)
    {
        $filter = $request->input('filter', 'last_24_hours');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Define date ranges based on filters
        $endDate = now();
        $startDate = match ($filter) {
            'last_24_hours' => $endDate->copy()->subDay()->startOfDay(),
            'last_7_days' => $endDate->copy()->subDays(7),
            'last_30_days' => $endDate->copy()->subDays(30),
            'last_60_days' => $endDate->copy()->subDays(60),
            'last_90_days' => $endDate->copy()->subDays(90),
            'custom' => $startDate ? Carbon::parse($startDate) : null,
            'all_time' => null, // No start date for all_time
        };

        // Handle custom date range for 'custom' filter
        if ($filter === 'custom' && $request->input('end_date')) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        // Only apply date range filtering if the filter is NOT 'all_time'
        $baseQuery = OpportunityState::query();
        if ($filter !== 'all_time') {
            $baseQuery = $baseQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Total earnings (no status filter)
        $totalEarnings = $baseQuery->clone()
            ->selectRaw(
                match ($filter) {
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
            ->pluck(
                'value',
                'formatted_date'
            );

        // Failed earnings
        $failedEarnings = $baseQuery->clone()
            ->where('opportunity_status_id', 5)
            ->selectRaw("DATE_FORMAT(created_at, '%d %b') as formatted_date, SUM(opportunity_value) as value")
            ->orderBy('formatted_date')
            ->groupBy('formatted_date')->pluck(
                'value',
                'formatted_date'
            );

        // Return the data as JSON
        if ($request->ajax()) {
            return response()->json([
                'totalEarnings' => $totalEarnings,
                'completedEarnings' => $completedEarnings,
                'failedEarnings' => $failedEarnings,
            ]);
        }

        $assets = ['chart', 'animation'];

        // Pass the data to the view for initial page load
        return view('dashboards.charts.chart-earning', compact('assets', 'filterResult',));
    }

    /*
     * Menu Style Routs
     */
    public function horizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.horizontal', compact('assets'));
    }
    public function dualhorizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-horizontal', compact('assets'));
    }
    public function dualcompact(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-compact', compact('assets'));
    }
    public function boxed(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed', compact('assets'));
    }
    public function boxedfancy(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed-fancy', compact('assets'));
    }

    /*
     * Pages Routs
     */
    public function billing(Request $request)
    {
        return view('special-pages.billing');
    }

    public function calender(Request $request)
    {
        $assets = ['calender'];
        return view('special-pages.calender', compact('assets'));
    }

    public function kanban(Request $request)
    {
        return view('special-pages.kanban');
    }

    public function pricing(Request $request)
    {
        return view('special-pages.pricing');
    }

    public function rtlsupport(Request $request)
    {
        return view('special-pages.rtl-support');
    }

    public function timeline(Request $request)
    {
        return view('special-pages.timeline');
    }


    /*
     * Widget Routs
     */
    public function widgetbasic(Request $request)
    {
        return view('widget.widget-basic');
    }
    public function widgetchart(Request $request)
    {
        $assets = ['chart'];
        return view('widget.widget-chart', compact('assets'));
    }
    public function widgetcard(Request $request)
    {
        return view('widget.widget-card');
    }

    /*
     * Maps Routs
     */
    public function google(Request $request)
    {
        return view('maps.google');
    }
    public function vector(Request $request)
    {
        return view('maps.vector');
    }

    /*
     * Auth Routs
     */
    public function signin(Request $request)
    {
        return view('auth.login');
    }
    public function signup(Request $request)
    {
        return view('auth.register');
    }
    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }
    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }
    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }

    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    /*
     * uisheet Page Routs
     */
    public function uisheet(Request $request)
    {
        return view('uisheet');
    }

    /*
     * Form Page Routs
     */
    public function element(Request $request)
    {
        return view('forms.element');
    }

    public function wizard(Request $request)
    {
        return view('forms.wizard');
    }

    public function validation(Request $request)
    {
        return view('forms.validation');
    }

    /*
     * Table Page Routs
     */
    public function bootstraptable(Request $request)
    {
        return view('table.bootstraptable');
    }

    public function datatable(Request $request)
    {
        return view('table.datatable');
    }

    /*
     * Icons Page Routs
     */

    public function solid(Request $request)
    {
        return view('icons.solid');
    }

    public function outline(Request $request)
    {
        return view('icons.outline');
    }

    public function dualtone(Request $request)
    {
        return view('icons.dualtone');
    }

    public function colored(Request $request)
    {
        return view('icons.colored');
    }

    /*
     * Extra Page Routs
     */
    public function privacypolicy(Request $request)
    {
        return view('privacy-policy');
    }
    public function termsofuse(Request $request)
    {
        return view('terms-of-use');
    }


    /*
    * Landing Page Routs
    */
    public function landing_index(Request $request)
    {
        return view('landing-pages.pages.index');
    }
    public function landing_blog(Request $request)
    {
        return view('landing-pages.pages.blog');
    }
    public function landing_about(Request $request)
    {
        return view('landing-pages.pages.about');
    }
    public function landing_blog_detail(Request $request)
    {
        return view('landing-pages.pages.blog-detail');
    }
    public function landing_contact(Request $request)
    {
        return view('landing-pages.pages.contact-us');
    }
    public function landing_ecommerce(Request $request)
    {
        return view('landing-pages.pages.ecommerce-landing-page');
    }
    public function landing_faq(Request $request)
    {
        return view('landing-pages.pages.faq');
    }
    public function landing_feature(Request $request)
    {
        return view('landing-pages.pages.feature');
    }
    public function landing_pricing(Request $request)
    {
        return view('landing-pages.pages.pricing');
    }
    public function landing_saas(Request $request)
    {
        return view('landing-pages.pages.saas-marketing-landing-page');
    }
    public function landing_shop(Request $request)
    {
        return view('landing-pages.pages.shop');
    }
    public function landing_shop_detail(Request $request)
    {
        return view('landing-pages.pages.shop_detail');
    }
    public function landing_software(Request $request)
    {
        return view('landing-pages.pages.software-landing-page');
    }
    public function landing_startup(Request $request)
    {
        return view('landing-pages.pages.startup-landing-page');
    }
}
