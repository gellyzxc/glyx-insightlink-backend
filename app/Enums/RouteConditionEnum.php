<?php

namespace App\Enums;

use App\Handlers\CountryRouteHandler;
use App\Handlers\DeviceTypeRouteHandler;
use App\Handlers\LanguageRouteHandler;
use App\Handlers\RefererRouteHandler;
use App\Handlers\TimeRouteHandler;
use App\Handlers\WeekdayRouteHandler;
use App\Models\RouteSetting;

enum RouteConditionEnum: string
{

    case Country = 'country';
    case Time = 'time';
    case Device = 'device';
    case Language = 'language';
    case Referer = 'referer';
    case Weekday = 'weekday';

    public function handler()
    {
        return match ($this) {
            self::Country => CountryRouteHandler::class,
            self::Time => TimeRouteHandler::class,
            self::Device => DeviceTypeRouteHandler::class,
            self::Referer => RefererRouteHandler::class,
            self::Language => LanguageRouteHandler::class,
            self::Weekday => WeekdayRouteHandler::class,
        };
    }

    public function model(): RouteSetting
    {
        return RouteSetting::where('name', $this)->first();
    }
}
