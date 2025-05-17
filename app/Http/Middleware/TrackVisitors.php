<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for certain routes or bots
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        // Process the request first
        $response = $next($request);

        // Track the visitor after the request is processed
        $this->trackVisit($request);

        return $response;
    }

    /**
     * Determine if tracking should be skipped.
     */
    protected function shouldSkip(Request $request): bool
    {
        // Skip tracking for API routes
        if ($request->is('api/*')) {
            return true;
        }

        // Skip tracking for assets
        if ($request->is('*.js', '*.css', '*.jpg', '*.png', '*.gif', '*.ico', '*.svg')) {
            return true;
        }

        // Skip tracking for admin routes if needed
        // if ($request->is('admin/*')) {
        //     return true;
        // }

        return false;
    }

    /**
     * Track the visitor.
     */
    protected function trackVisit(Request $request): void
    {
        try {
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());

            // Get or create session ID
            $sessionId = Session::getId();

            // Check if this is a bot
            $isBot = $agent->isRobot();

            // Determine if this is a unique visit
            $isUnique = $this->isUniqueVisit($request->ip(), $request->userAgent());

            // Get device type
            $deviceType = 'unknown';
            if ($agent->isDesktop()) {
                $deviceType = 'desktop';
            } elseif ($agent->isTablet()) {
                $deviceType = 'tablet';
            } elseif ($agent->isPhone()) {
                $deviceType = 'mobile';
            }

            // Get browser and platform
            $browser = $agent->browser();
            $platform = $agent->platform();

            // Get geographic data (simplified version)
            // In a production environment, you would use a proper geolocation service
            $geoData = $this->getGeoData($request->ip());

            // Create visitor record
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $sessionId,
                'page_visited' => $request->fullUrl(),
                'referrer' => $request->header('referer'),
                'device_type' => $deviceType,
                'browser' => $browser,
                'platform' => $platform,
                'country' => $geoData['country'] ?? 'Unknown',
                'region' => $geoData['region'] ?? 'Unknown',
                'city' => $geoData['city'] ?? 'Unknown',
                'is_bot' => $isBot,
                'is_unique' => $isUnique
            ]);
        } catch (\Exception $e) {
            // Log the error but don't disrupt the user experience
            logger()->error('Error tracking visitor: ' . $e->getMessage());
        }
    }

    /**
     * Determine if this is a unique visit.
     */
    protected function isUniqueVisit(string $ip, string $userAgent): bool
    {
        // Check if this IP + User Agent combination has visited today
        $visited = Visitor::where('ip_address', $ip)
            ->where('user_agent', $userAgent)
            ->whereDate('created_at', Carbon::today())
            ->exists();

        return !$visited;
    }

    /**
     * Get geographic data from IP address.
     *
     * This is a simplified version. In production, you would use a proper
     * geolocation service like MaxMind GeoIP, ipinfo.io, or IP-API.
     */
    protected function getGeoData(string $ip): array
    {
        // For local development or testing
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            return [
                'country' => 'Indonesia',
                'region' => 'Jakarta',
                'city' => 'Jakarta'
            ];
        }

        // Simple mapping for demo purposes
        // In production, use a proper geolocation service
        $regions = [
            'Jakarta',
            'Jawa Barat',
            'Jawa Tengah',
            'Jawa Timur',
            'Banten',
            'Yogyakarta',
            'Bali',
            'Sumatera Utara',
            'Sumatera Barat',
            'Sumatera Selatan',
            'Kalimantan Timur',
            'Sulawesi Selatan'
        ];

        $cities = [
            'Jakarta' => ['Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara'],
            'Jawa Barat' => ['Bandung', 'Bekasi', 'Bogor', 'Depok', 'Cimahi'],
            'Jawa Tengah' => ['Semarang', 'Solo', 'Magelang', 'Pekalongan', 'Tegal'],
            'Jawa Timur' => ['Surabaya', 'Malang', 'Kediri', 'Jember', 'Pasuruan'],
            'Banten' => ['Tangerang', 'Serang', 'Cilegon', 'Tangerang Selatan'],
            'Yogyakarta' => ['Yogyakarta', 'Sleman', 'Bantul'],
            'Bali' => ['Denpasar', 'Badung', 'Gianyar'],
            'Sumatera Utara' => ['Medan', 'Binjai', 'Pematangsiantar'],
            'Sumatera Barat' => ['Padang', 'Bukittinggi', 'Payakumbuh'],
            'Sumatera Selatan' => ['Palembang', 'Prabumulih', 'Lubuklinggau'],
            'Kalimantan Timur' => ['Samarinda', 'Balikpapan', 'Bontang'],
            'Sulawesi Selatan' => ['Makassar', 'Parepare', 'Palopo']
        ];

        // Generate a random but consistent region based on IP
        $ipSum = array_sum(array_map('ord', str_split($ip)));
        $regionIndex = $ipSum % count($regions);
        $region = $regions[$regionIndex];

        // Generate a random but consistent city based on region
        $regionCities = $cities[$region] ?? ['Unknown'];
        $cityIndex = $ipSum % count($regionCities);
        $city = $regionCities[$cityIndex];

        return [
            'country' => 'Indonesia',
            'region' => $region,
            'city' => $city
        ];
    }
}
