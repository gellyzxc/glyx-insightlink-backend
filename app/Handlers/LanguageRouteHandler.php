<?php

namespace App\Handlers;

use App\Interfaces\RouteHandlerInterface;
use App\Models\Link;
use App\Models\LinkRouteSetting;
use App\Models\LinkSetting;
use Illuminate\Http\Request;

class LanguageRouteHandler implements RouteHandlerInterface
{

    public function matches(LinkRouteSetting $routeSetting): bool
    {
        $acceptLanguage = request()->header('accept-language');
        if (!$acceptLanguage) {
            return false;
        }

        $languages = explode(',', $acceptLanguage);
        $primaryLang = substr($languages[0], 0, 2);

        return in_array($primaryLang, $routeSetting->value, true);
    }

}
