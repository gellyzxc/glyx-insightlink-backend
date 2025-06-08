<?php

namespace App\Providers;

use ClickHouseDB\Client;
use Illuminate\Support\ServiceProvider;

class ClickhouseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            $config = $app['config']['database.connections.clickhouse'];
            return new Client([
                'host' => $config['host'],
                'port' => $config['port'],
                'username' => $config['username'],
                'password' => $config['password'],
                'database' => $config['database'],
            ]);
        });
    }

    public function boot(): void
    {
    }
}
