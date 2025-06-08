<?php

namespace App\Handlers;

use App\Interfaces\RouteHandlerInterface;
use App\Models\Link;
use App\Models\LinkRouteSetting;
use App\Models\LinkSetting;
use Illuminate\Http\Request;

class CountryRouteHandler implements RouteHandlerInterface
{

    public function matches(LinkRouteSetting $routeSetting): bool
    {
        $userCountry = geoip()->getLocation(request()->ip())->iso_code;

        return in_array(strtoupper($userCountry), $routeSetting->value, true);
    }

}
