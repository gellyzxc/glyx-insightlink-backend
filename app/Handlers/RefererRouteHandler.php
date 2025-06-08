<?php

namespace App\Handlers;

use App\Interfaces\RouteHandlerInterface;
use App\Models\Link;
use App\Models\LinkRouteSetting;
use App\Models\LinkSetting;
use Illuminate\Http\Request;

class RefererRouteHandler implements RouteHandlerInterface
{

    public function matches(LinkRouteSetting $routeSetting): bool
    {
        $referer = request()->header('referer');

        if (!$referer) {
            return false;
        }

        foreach ($routeSetting->value as $pattern) {
            if (str_contains($referer, $pattern)) {
                return true;
            }
        }

        return false;
    }
}
