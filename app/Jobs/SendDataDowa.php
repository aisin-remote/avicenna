<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class SendDataDowa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data = [];
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $token)
    {
        $this->data = $data;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $client->post(env('DOWA_BASE_URL').'/products', [
            'body' => [
                'data' => $this->data
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
    }
}
