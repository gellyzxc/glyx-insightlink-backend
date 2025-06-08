<?php

namespace App\Handlers;

use App\Interfaces\RouteHandlerInterface;
use App\Models\Link;
use App\Models\LinkRouteSetting;
use App\Models\LinkSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeRouteHandler implements RouteHandlerInterface
{

    public function matches(LinkRouteSetting $routeSetting): bool
    {
        $now = Carbon::now();
        $from = Carbon::createFromTimeString($routeSetting->value['from']);
        $to = Carbon::createFromTimeString($routeSetting->value['to']);

        $from->setDate($now->year, $now->month, $now->day);
        $to->setDate($now->year, $now->month, $now->day);

        if ($from->gt($to)) {
            return $now->greaterThanOrEqualTo($from) || $now->lessThanOrEqualTo($to);
        }

        return $now->between($from, $to);
    }
}
