<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BannerController extends Controller {

    public function getLoginCounter( $name ) {

        $user = User::where( "name", $name )->first();
        $counter = $user->counter;

        return $counter;
    }

    public function setLoginCounter( $name ) {

       User::where( "name", $name )->increment( "counter" );
    }

    public function resetLoginCounter( $id ) {

        $user = User::find( $id );
        $user->counter = 0;

        $user->update();
    }

    public function setBannedTime( $name ) {

        $user = User::where( "name", $name )->first();
        $user->banning = Carbon::now()->addHour()->addMinute();

        $user->update();
    }

    public function resetBannedTime( $id ) {

        $user = User::find( $id );
        $user->banning = null;

        $user->update();
    }
}
