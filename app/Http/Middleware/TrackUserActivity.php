<?php

namespace App\Http\Middleware;

use App\Helpers\IPHelper;
use App\Models\UserActivity;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;
use Torann\GeoIP\Facades\GeoIP;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $agent = new Agent();
            $device = $agent->device();
            $platform = $agent->platform();
            $browser = $agent->browser();
            $currentDate = Carbon::today();
            $ipAddress = IPHelper::getIp();
            $ipInfo = $this->getCountryByIp($ipAddress);
            $countryCode = $ipInfo->geoplugin_countryCode ?? '';
            $countryName = $ipInfo->geoplugin_countryName ?? '';
            $region = $ipInfo->geoplugin_region ?? '';
            $regionCode = $ipInfo->geoplugin_regionCode ?? '';
            $regionName = $ipInfo->geoplugin_regionName ?? '';
            if (empty($ipAddress)) {
                $ipAddress = $ipInfo->geoplugin_request ?? '';
            }
            $activityExists = UserActivity::query()->where('ip_address', $ipAddress)
                ->whereDate('created_at', $currentDate)
                ->where('browser', $browser)
                ->exists();
            if (!$activityExists) {
                $activityLog = new UserActivity();
                $activityLog->user_id = auth()->id() ?? '';
                $activityLog->ip_address = $ipAddress;
                $activityLog->platform = $platform;
                $activityLog->browser = $browser;
                $activityLog->device = $device;
                $activityLog->country_code = $countryCode;
                $activityLog->country_name = $countryName;
                $activityLog->region = $region;
                $activityLog->region_code = $regionCode;
                $activityLog->region_name = $regionName;
                $activityLog->user_agent = $request->header('User-Agent');
                $activityLog->ip_info = json_encode($ipInfo);
                $activityLog->save();
            }
        }
        return $next($request);
    }

    private function getCountryByIp(string $ip)
    {
        try {
            $ipdat = @json_decode(file_get_contents(
                "http://www.geoplugin.net/json.gp?ip=" . $ip));
            return $ipdat;
        } catch (\Exception $exception) {
            Log::error('[LogAccessListener][handle] error: ' . $exception->getMessage());
        }
    }
}
