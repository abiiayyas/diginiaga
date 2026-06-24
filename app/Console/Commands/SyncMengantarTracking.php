<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncMengantarTracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync active shipment tracking status from Mengantar API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Mengantar tracking sync...');
        
        try {
            app(\App\Services\MengantarService::class)->syncTrackingForActiveShipments();
            $this->info('Tracking sync completed successfully.');
        } catch (\Exception $e) {
            $this->error('Tracking sync failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
