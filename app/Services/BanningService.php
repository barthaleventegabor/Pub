<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class BanningService
{
    public function __construct() {
    }

    public function getLoginCounter( $name ) {

        $user = User::where( "name", $name )->first();
        $counter = $user->counter;

        return $counter;
    }

    public function setLoginCounter( $name ) {

       User::where( "name", $name )->increment( "counter" );
    }

    public function resetLoginCounter( $user ) {

        $user->counter = 0;
        $user->update();
    }

    public function setBannedTime( $name ) {

        $user = User::where( "name", $name )->first();
        $user->banning = Carbon::now()->addHour()->addMinute();

        $user->update();
    }

    public function resetBannedTime( $user ) {

        $user->banning = null;
        $user->update();
    }
}
