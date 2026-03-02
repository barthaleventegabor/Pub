<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\DatabaseBackupJob;

// Schedule::command('backup:run --only-db')->everyMinute();
Schedule::job(new DatabaseBackupJob)->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
