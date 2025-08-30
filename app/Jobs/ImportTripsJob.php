<?php

namespace App\Jobs;

use Exception;
use App\Models\Ship;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportTripsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // 10 min
    public $tries = 5;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        try {
            $url = "https://api.heritage-expeditions.com/v1/trips/";

            Log::info("Trips import started...");

            $response = Http::withHeaders([
                'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
                'Accept'        => 'application/json',
            ])->retry(3, 100)->timeout(120)->get($url);

            if (! $response->successful()) {
                throw new \Exception("API request failed with status: " . $response->status());
            }

            $trips = $response->json();

            // Chunk into smaller jobs
            $chunks = array_chunk($trips, 10);

            foreach ($chunks as $chunk) {
                ImportChunkJob::dispatch($chunk);
            }

            Log::info("Trips import dispatched into chunks successfully!");
        } catch (\Throwable $e) {
            Log::error("ImportTripsJob failed: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            $this->release(60); // retry after 1 min
        }
    }
}
