<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\LinkSetting;
use ClickHouseDB\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SaveRedirectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param array $link
     * @param ?array $setting
     * @param array $request
     */
    public function __construct(protected Link $link, protected ?LinkSetting $setting, protected array $requestData)
    {
    }

    public function handle(Client $client): void
    {
        $client->insert('redirects_data2', [[
            $this->link->id,
            $this->setting->id ?? null,
            ...$this->requestData,
        ]],
            [
                'link_id',
                'variant_id',
                ...array_keys($this->requestData),
            ]
        );
    }

//    protected function getDeviceType(?string $userAgent): string
//    {
//        $agent = new \Jenssegers\Agent\Agent();
//
//        $agent->setUserAgent(trim($userAgent));
//
//        if ($agent->isMobile() && !$agent->isTablet()) return 'mobile';
//        if ($agent->isTablet()) return 'tablet';
//        return 'desktop';
//    }
}
