<?php

namespace App\Handlers;

use App\Interfaces\RouteHandlerInterface;
use App\Models\Link;
use App\Models\LinkRouteSetting;
use App\Models\LinkSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeekdayRouteHandler implements RouteHandlerInterface
{

    public function matches(LinkRouteSetting $routeSetting): bool
    {
        $currentDay = Carbon::now()->format('l');

        return in_array(strtolower($currentDay), $routeSetting->value, true);
    }

}
