<?php

namespace App\Services;

use App\Enums\RouteConditionEnum;
use App\Helpers\UserRequestHelper;
use App\Jobs\GetLinkClassificationJob;
use App\Jobs\SaveRedirectJob;
use App\Models\Link;
use App\Models\LinkSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LinkService
{
    public function __construct()
    {
    }

    public function createLink(array $data): Link
    {
        $link = Link::create([
            ...$data,
            'user_id' => '01974a78-17d6-71e3-b9fe-77fd6c82e655',
            'active' => true
        ]);

        foreach ($data['variants'] as $variant) {
            $setting = $link->settings()->create([
                'active' => true,
                'priority' => $variant['priority'],
                'url' => $variant['url'],
                'operand' => $variant['operand'],
            ]);

            if ($link->url !== $setting->url) {
                $this->getLinkClassification($setting);
            }

            foreach ($variant['conditions'] as $condition) {
                $routeModel = RouteConditionEnum::from($condition['condition']);
                $setting->linkRouteSettings()->create([
                    'route_setting_id' => $routeModel->model()->id,
                    'value' => $condition['value'],
                ]);
            }
        }

        $this->getLinkClassification($link);

        return $link;
    }

    public function updateLink(Link $link, array $data): Link
    {
        $link->update([
            'name' => $data['name'],
            'shortcut' => $data['shortcut'],
            'url' => $data['url'],
            'expires_at' => $data['expires_at'] ?? null,
            'active' => $data['active'] ?? true,
        ]);

        $remainingVariantIds = [];

        foreach ($data['variants'] as $variantData) {
            $setting = $link->settings()->updateOrCreate(
                [
                    'id' => $variantData['id'] ?? null,
                ],
                [
                    'active' => true,
                    'priority' => $variantData['priority'],
                    'url' => $variantData['url'],
                    'operand' => $variantData['operand'],
                ]
            );

            $remainingVariantIds[] = $setting->id;

            $remainingConditionIds = [];

            foreach ($variantData['conditions'] as $conditionData) {
                $routeModel = RouteConditionEnum::from($conditionData['condition']);

                $condition = $setting->linkRouteSettings()->updateOrCreate(
                    [
                        'id' => $conditionData['id'] ?? null,
                        'route_setting_id' => $routeModel->model()->id,
                    ],
                    [
                        'value' => $conditionData['value'],
                    ]
                );

                $remainingConditionIds[] = $condition->id;
            }

            $setting->linkRouteSettings()
                ->whereNotIn('id', $remainingConditionIds)
                ->delete();
        }

        $link->settings()
            ->whereNotIn('id', $remainingVariantIds)
            ->delete();

        cache()->forget("link:{$link->id}:settings");
        cache()->forget("link:{$link->id}");

        return $link->fresh();
    }

    public function getLinkSettings(Link $link): Collection
    {
        return cache()->remember("link:{$link->id}:settings", now()->addMinutes(10), function () use ($link) {
            return $link->settings()->orderBy('priority', 'ASC')->with('linkRouteSettings.routeSetting')->get();
        });
    }

    public function getRedirectLink(Link $link)
    {
        $settings = $this->getLinkSettings($link);

        $requestData = UserRequestHelper::getClientInfo(request());

        foreach ($settings as $setting) {
            switch ($setting->operand) {
                case 'OR':
                    foreach ($setting->linkRouteSettings as $linkRouteSetting) {
                        $routeHandler = RouteConditionEnum::from($linkRouteSetting->routeSetting->name);

                        if (app($routeHandler->handler())->matches($linkRouteSetting)) {
                            SaveRedirectJob::dispatch($link, $setting, $requestData);
                            return $linkRouteSetting->linkSetting->url;
                        }
                    }
                    break;

                case 'AND':
                    $allMatched = true;

                    foreach ($setting->linkRouteSettings as $linkRouteSetting) {
                        $routeHandler = RouteConditionEnum::from($linkRouteSetting->routeSetting->name);

                        if (!app($routeHandler->handler())->matches($linkRouteSetting)) {
                            $allMatched = false;
                            break;
                        }
                    }

                    if ($allMatched) {

                        SaveRedirectJob::dispatch($link, $setting, $requestData);
                        return $setting->url;
                    }

                    break;
            }
        }

        SaveRedirectJob::dispatch($link, null, $requestData);
        return $link->url;
    }

    public function getLinkClassification(Link|LinkSetting $link): void
    {
        GetLinkClassificationJob::dispatch($link);
    }
}
