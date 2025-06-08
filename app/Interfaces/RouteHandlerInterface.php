<?php

namespace App\Interfaces;

use App\Models\Link;
use App\Models\LinkRouteSetting;
use App\Models\LinkSetting;
use Illuminate\Http\Request;

interface RouteHandlerInterface
{
    public function matches(LinkRouteSetting $routeSetting): bool;
}
