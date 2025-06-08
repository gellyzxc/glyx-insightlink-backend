<?php

namespace App\Console\Commands;

use ClickHouseDB\Client;
use Illuminate\Console\Command;

class CreateClickhouseRedirectTableCommand extends Command
{
    protected $signature = 'clickhouse:init';

    protected $description = 'Command description';

    public function handle(Client $client): void
    {
        $client->write("
                         CREATE TABLE redirects
                        (
                            id UUID DEFAULT generateUUIDv4(),
                            link_id UUID,
                            variant_id UUID,

                            referer String,
                            utm_source String,
                            utm_medium String,
                            utm_campaign String,

                            ip_address IPv4,
                            geo_country String,
                            geo_region String,
                            geo_city String,

                            user_agent String,
                            browser String,
                            browser_version String,
                            platform String,
                            device String,
                            is_mobile UInt8,
                            is_robot UInt8,

                            session_id String,
                            ip String,
                            timestamp DateTime DEFAULT now()
                        )
                        ENGINE = MergeTree
                        PARTITION BY toYYYYMM(timestamp)
                        ORDER BY (timestamp)
                        TTL timestamp + INTERVAL 1 YEAR
                        SETTINGS index_granularity = 8192;
                    ");
    }
}
