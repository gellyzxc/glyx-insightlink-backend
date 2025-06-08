<?php

namespace App\Console\Commands;

use ClickHouseDB\Client;
use Illuminate\Console\Command;

class CountClickhouseRedirectCommand extends Command
{
    protected $signature = 'clickhouse:redirects-count';

    protected $description = 'Command description';

    public function handle(Client $client): void
    {
        $statement = $client->select('SELECT * FROM redirects_data2');

        dump($statement, $statement->count());
    }
}
