<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class UserRequestHelper
{
    public static function getClientInfo(Request $request): array
    {
        $ip = $request->ip();

        $geo = geoip()->getLocation($ip);

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent($request->userAgent());

        return [
            'ip' => $ip,
            'referer' => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'is_mobile' => (integer) $agent->isMobile(),
            'is_robot' => (integer) $agent->isRobot(),
            'geo_country' => $geo->country ?? null,
            'geo_city' => $geo->city ?? null,
            'geo_region' => $geo->state ?? null,
            'timestamp' => now(),
            'utm_source' => $request->get('utm_source'),
            'utm_medium' => $request->get('utm_medium'),
            'utm_campaign' => $request->get('utm_campaign'),
            'session_id' => $request->cookie('session_id'),
        ];
    }

}
