<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 900;
    public $tries = 2;
    
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        
        Artisan::call( "backup:run", [
            "--only-db" => true,
        ]);
    }
}
