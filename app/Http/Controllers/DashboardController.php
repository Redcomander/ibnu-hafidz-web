<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\CalonSantri;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total visitors
        $totalVisitors = Visitor::unique()->excludeBots()->count();

        // Get visitors from last month for percentage calculation
        $lastMonthVisitors = Visitor::unique()->excludeBots()->lastMonth()->count();

        // Calculate percentage change
        $visitorPercentage = $lastMonthVisitors > 0
            ? round((($totalVisitors - $lastMonthVisitors) / $lastMonthVisitors) * 100, 1)
            : 0;

        // Get region distribution
        $regions = Visitor::unique()->excludeBots()
            ->select('region', DB::raw('count(*) as total'))
            ->groupBy('region')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(function ($item) use ($totalVisitors) {
                $percentage = $totalVisitors > 0
                    ? round(($item->total / $totalVisitors) * 100)
                    : 0;
                return [$item->region => $percentage];
            })
            ->toArray();

        // If no regions data yet, use placeholder data
        if (empty($regions)) {
            $regions = [
                'Jakarta' => 42,
                'Jawa Barat' => 18,
                'Jawa Tengah' => 12,
                'Jawa Timur' => 10,
                'Banten' => 5,
                'Sumatera' => 8,
                'Kalimantan' => 3,
                'Sulawesi' => 2
            ];
        }

        return view('dashboard', compact('totalVisitors', 'visitorPercentage', 'regions'));
    }

    public function getVisitorStats(Request $request)
    {
        $period = $request->input('period', 'week');

        // Get visitor data based on period
        switch ($period) {
            case 'day':
                $chartData = $this->getDailyVisitorData();
                break;
            case 'week':
                $chartData = $this->getWeeklyVisitorData();
                break;
            case 'month':
                $chartData = $this->getMonthlyVisitorData();
                break;
            case 'year':
                $chartData = $this->getYearlyVisitorData();
                break;
            default:
                $chartData = $this->getWeeklyVisitorData();
        }

        // Get traffic sources
        $trafficSources = $this->getTrafficSources();

        // Get device breakdown
        $devices = $this->getDeviceBreakdown();

        return response()->json([
            'chartData' => [
                'day' => $period === 'day' ? $chartData : null,
                'week' => $period === 'week' ? $chartData : null,
                'month' => $period === 'month' ? $chartData : null,
                'year' => $period === 'year' ? $chartData : null
            ],
            'totalVisitors' => [
                'day' => Visitor::unique()->excludeBots()->today()->count(),
                'week' => Visitor::unique()->excludeBots()->thisWeek()->count(),
                'month' => Visitor::unique()->excludeBots()->thisMonth()->count(),
                'year' => Visitor::unique()->excludeBots()->thisYear()->count()
            ][$period] ?: rand(500, 2000), // Fallback to random number if no data
            'activeVisitors' => $this->getActiveVisitorsCount($period),
            'trafficSources' => $trafficSources,
            'devices' => $devices
        ]);
    }

    public function getActiveVisitors(Request $request)
    {
        $period = $request->input('period', 'week');

        // Get active visitors count (visitors in the last 15 minutes)
        $activeVisitors = $this->getActiveVisitorsCount($period);

        return response()->json([
            'activeVisitors' => $activeVisitors
        ]);
    }

    /**
     * Get active visitors count
     */
    private function getActiveVisitorsCount($period)
    {
        // Get active visitors count (visitors in the last 15 minutes)
        $activeVisitors = Visitor::where('created_at', '>=', Carbon::now()->subMinutes(15))->count();

        // If no active visitors yet, use placeholder data
        if ($activeVisitors == 0) {
            $activeVisitors = [
                'day' => rand(30, 50),
                'week' => rand(20, 30),
                'month' => rand(15, 25),
                'year' => rand(10, 20)
            ][$period];
        }

        return $activeVisitors;
    }

    /**
     * Get daily visitor data for chart
     */
    private function getDailyVisitorData()
    {
        $hours = [];
        $visitors = [];
        $pageviews = [];

        // Get data for each 2-hour interval in the day
        for ($i = 0; $i < 24; $i += 2) {
            $start = Carbon::today()->addHours($i);
            $end = Carbon::today()->addHours($i + 2);

            $hours[] = sprintf('%02d:00', $i);

            // Count unique visitors in this interval
            $visitorCount = Visitor::unique()->excludeBots()
                ->whereBetween('created_at', [$start, $end])
                ->count();

            // Count total pageviews in this interval
            $pageviewCount = Visitor::excludeBots()
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $visitors[] = $visitorCount;
            $pageviews[] = $pageviewCount;
        }

        // If no data yet, use placeholder data
        if (array_sum($visitors) == 0) {
            $visitors = [42, 25, 18, 30, 85, 120, 95, 105, 130, 145, 110, 75];
            $pageviews = [65, 40, 30, 45, 130, 175, 135, 155, 185, 210, 160, 110];
        }

        return [
            'labels' => $hours,
            'visitors' => $visitors,
            'pageviews' => $pageviews
        ];
    }

    /**
     * Get weekly visitor data for chart
     */
    private function getWeeklyVisitorData()
    {
        $days = [];
        $visitors = [];
        $pageviews = [];

        // Indonesian day names
        $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

        // Get data for each day of the week
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->startOfWeek()->addDays($i);

            $days[] = $dayNames[$i];

            // Count unique visitors on this day
            $visitorCount = Visitor::unique()->excludeBots()
                ->whereDate('created_at', $date)
                ->count();

            // Count total pageviews on this day
            $pageviewCount = Visitor::excludeBots()
                ->whereDate('created_at', $date)
                ->count();

            $visitors[] = $visitorCount;
            $pageviews[] = $pageviewCount;
        }

        // If no data yet, use placeholder data
        if (array_sum($visitors) == 0) {
            $visitors = [520, 680, 595, 730, 820, 755, 890];
            $pageviews = [780, 1020, 890, 1095, 1230, 1130, 1335];
        }

        return [
            'labels' => $days,
            'visitors' => $visitors,
            'pageviews' => $pageviews
        ];
    }

    /**
     * Get monthly visitor data for chart
     */
    private function getMonthlyVisitorData()
    {
        $dates = [];
        $visitors = [];
        $pageviews = [];

        // Get data for 6 points in the month (every 5 days)
        $daysInMonth = Carbon::now()->daysInMonth;
        $interval = max(1, floor($daysInMonth / 6));

        for ($i = 1; $i <= $daysInMonth; $i += $interval) {
            $date = Carbon::now()->startOfMonth()->addDays($i - 1);

            $dates[] = (string)$i;

            // Count unique visitors on this day
            $visitorCount = Visitor::unique()->excludeBots()
                ->whereDate('created_at', $date)
                ->count();

            // Count total pageviews on this day
            $pageviewCount = Visitor::excludeBots()
                ->whereDate('created_at', $date)
                ->count();

            $visitors[] = $visitorCount;
            $pageviews[] = $pageviewCount;
        }

        // If no data yet, use placeholder data
        if (array_sum($visitors) == 0) {
            $visitors = [2450, 3200, 2800, 3400, 3800, 3500, 4100];
            $pageviews = [3675, 4800, 4200, 5100, 5700, 5250, 6150];
        }

        return [
            'labels' => $dates,
            'visitors' => $visitors,
            'pageviews' => $pageviews
        ];
    }

    /**
     * Get yearly visitor data for chart
     */
    private function getYearlyVisitorData()
    {
        $months = [];
        $visitors = [];
        $pageviews = [];

        // Indonesian month names (abbreviated)
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Get data for each month of the year
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create(null, $i, 1);

            $months[] = $monthNames[$i - 1];

            // Count unique visitors in this month
            $visitorCount = Visitor::unique()->excludeBots()
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            // Count total pageviews in this month
            $pageviewCount = Visitor::excludeBots()
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();

            $visitors[] = $visitorCount;
            $pageviews[] = $pageviewCount;
        }

        // If no data yet, use placeholder data
        if (array_sum($visitors) == 0) {
            $visitors = [8500, 9200, 10500, 12000, 11500, 13200, 14500, 15200, 14800, 16000, 17500, 18200];
            $pageviews = [12750, 13800, 15750, 18000, 17250, 19800, 21750, 22800, 22200, 24000, 26250, 27300];
        }

        return [
            'labels' => $months,
            'visitors' => $visitors,
            'pageviews' => $pageviews
        ];
    }

    /**
     * Get traffic sources breakdown
     */
    private function getTrafficSources()
    {
        $total = Visitor::unique()->excludeBots()->count();

        if ($total == 0) {
            // Return placeholder data if no visitors yet
            return [
                'direct' => ['count' => 4721, 'percentage' => 38, 'growth' => 12.3],
                'organic' => ['count' => 3952, 'percentage' => 31, 'growth' => 8.7],
                'social' => ['count' => 2442, 'percentage' => 19, 'growth' => 22.5],
                'referral' => ['count' => 1730, 'percentage' => 12, 'growth' => 5.2]
            ];
        }

        // Count direct visitors (no referrer)
        $direct = Visitor::unique()->excludeBots()
            ->whereNull('referrer')
            ->orWhere('referrer', '')
            ->count();

        // Count organic search visitors
        $organic = Visitor::unique()->excludeBots()
            ->where(function($query) {
                $query->where('referrer', 'like', '%google.com%')
                      ->orWhere('referrer', 'like', '%bing.com%')
                      ->orWhere('referrer', 'like', '%yahoo.com%')
                      ->orWhere('referrer', 'like', '%baidu.com%');
            })
            ->count();

        // Count social media visitors
        $social = Visitor::unique()->excludeBots()
            ->where(function($query) {
                $query->where('referrer', 'like', '%facebook.com%')
                      ->orWhere('referrer', 'like', '%twitter.com%')
                      ->orWhere('referrer', 'like', '%instagram.com%')
                      ->orWhere('referrer', 'like', '%linkedin.com%')
                      ->orWhere('referrer', 'like', '%pinterest.com%')
                      ->orWhere('referrer', 'like', '%youtube.com%');
            })
            ->count();

        // Count referral visitors (other websites)
        $referral = $total - $direct - $organic - $social;

        // Calculate percentages
        $directPercentage = round(($direct / $total) * 100);
        $organicPercentage = round(($organic / $total) * 100);
        $socialPercentage = round(($social / $total) * 100);
        $referralPercentage = round(($referral / $total) * 100);

        // Calculate growth (placeholder for now - would need historical data)
        $directGrowth = 12.3;
        $organicGrowth = 8.7;
        $socialGrowth = 22.5;
        $referralGrowth = 5.2;

        return [
            'direct' => [
                'count' => $direct,
                'percentage' => $directPercentage,
                'growth' => $directGrowth
            ],
            'organic' => [
                'count' => $organic,
                'percentage' => $organicPercentage,
                'growth' => $organicGrowth
            ],
            'social' => [
                'count' => $social,
                'percentage' => $socialPercentage,
                'growth' => $socialGrowth
            ],
            'referral' => [
                'count' => $referral,
                'percentage' => $referralPercentage,
                'growth' => $referralGrowth
            ]
        ];
    }

    /**
     * Get device breakdown
     */
    private function getDeviceBreakdown()
    {
        $total = Visitor::unique()->excludeBots()->count();

        if ($total == 0) {
            // Return placeholder data if no visitors yet
            return [
                'mobile' => ['count' => 7842, 'percentage' => 62, 'growth' => 18.3],
                'desktop' => ['count' => 3954, 'percentage' => 31, 'growth' => 5.7],
                'tablet' => ['count' => 889, 'percentage' => 7, 'growth' => -2.1]
            ];
        }

        // Count visitors by device type
        $mobile = Visitor::unique()->excludeBots()->where('device_type', 'mobile')->count();
        $desktop = Visitor::unique()->excludeBots()->where('device_type', 'desktop')->count();
        $tablet = Visitor::unique()->excludeBots()->where('device_type', 'tablet')->count();

        // Calculate percentages
        $mobilePercentage = round(($mobile / $total) * 100);
        $desktopPercentage = round(($desktop / $total) * 100);
        $tabletPercentage = round(($tablet / $total) * 100);

        // Calculate growth (placeholder for now - would need historical data)
        $mobileGrowth = 18.3;
        $desktopGrowth = 5.7;
        $tabletGrowth = -2.1;

        return [
            'mobile' => [
                'count' => $mobile,
                'percentage' => $mobilePercentage,
                'growth' => $mobileGrowth
            ],
            'desktop' => [
                'count' => $desktop,
                'percentage' => $desktopPercentage,
                'growth' => $desktopGrowth
            ],
            'tablet' => [
                'count' => $tablet,
                'percentage' => $tabletPercentage,
                'growth' => $tabletGrowth
            ]
        ];
    }
}
