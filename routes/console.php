<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('shipments:sync-tracking')->everyTwoHours()
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('orders:send-payment-reminders')->everyThreeHours()
    ->withoutOverlapping()
    ->runInBackground();

