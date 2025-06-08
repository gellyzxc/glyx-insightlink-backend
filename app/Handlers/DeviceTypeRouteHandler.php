<?php
namespace App\Handlers;

use App\Interfaces\RouteHandlerInterface;
use App\Models\LinkRouteSetting;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DeviceTypeRouteHandler implements RouteHandlerInterface
{
    protected Agent $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function matches(LinkRouteSetting $routeSetting): bool
    {
        $targetDevices = (array) $routeSetting->value;

        foreach ($targetDevices as $device) {
            if (
                ($device === 'mobile' && $this->agent->isMobile() && !$this->agent->isTablet()) ||
                ($device === 'tablet' && $this->agent->isTablet()) ||
                ($device === 'desktop' && !$this->agent->isMobile() && !$this->agent->isTablet())
            ) {
                return true;
            }
        }

        return false;
    }
}
