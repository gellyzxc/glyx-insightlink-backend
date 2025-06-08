<?php

namespace Database\Seeders;

use App\Models\RouteSetting;
use Illuminate\Database\Seeder;

class RouteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "label" => "По стране",
                "name" => "country"
            ],
            [
                "label" => "По времени",
                "name" => "time"
            ],
            [
                "label" => "По устройству",
                "name" => "device"
            ],
            [
                "label" => "По языку",
                "name" => "language"
            ],
            [
                "label" => "По рефереру",
                "name" => "referer"
            ],
            [
                "label" => "По дню недели",
                "name" => "weekday"
            ]
        ];

        foreach ($data as $datum) {
            RouteSetting::create([
                ...$datum,
                'active' => true
            ]);
        }
    }
}
