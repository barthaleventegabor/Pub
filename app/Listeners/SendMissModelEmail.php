<?php

namespace App\Listeners;

use App\Events\MissModelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvaildModelMail;


class SendMissModelEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MissModelEvent $event): void
    {
        Mail::to("bgeegegeg@gmail.com")->send(new InvaildModelMail($event->logData));
    }
}
