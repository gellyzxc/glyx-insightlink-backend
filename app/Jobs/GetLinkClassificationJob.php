<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\LinkSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetLinkClassificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Link|LinkSetting $link)
    {
    }

    public function handle(): void
    {
        $host = config('insightlink.classifier_host');

        $response = Http::timeout(600)->post($host, [
            'url' => $this->link->url,
        ]);

        if ($response->successful()) {
            $this->link->update([
               'classification' => $response->json()['tags'],
            ]);
        }

        dump($response->json());
    }
}
