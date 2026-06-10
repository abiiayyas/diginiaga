<?php

namespace App\Console\Commands;

use App\Services\BiteshipService;
use Illuminate\Console\Command;

class SyncBiteshipTracking extends Command
{
    protected $signature = 'shipments:sync-tracking';
    protected $description = 'Sync tracking status dari Biteship untuk shipment aktif';

    public function handle(BiteshipService $biteship): void
    {
        $this->info('Syncing Biteship tracking...');
        $biteship->syncTrackingForActiveShipments();
        $this->info('Done.');
    }
}
