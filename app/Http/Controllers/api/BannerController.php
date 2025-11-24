<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class BannerController extends Controller
{   
    public function getLoginCounter($name)
    {
        $user = User::where("name", $name)->first();
        return $user->counter;
    }
    public function setLoginCounter($name)
    {
        User::where("name", $name)->increment("counter");
    }

    public function resetLoginCounter($id)
    {
        $user = User::find($id);
        $user->counter = 0;
        $user->update();
    }

    public function setBanningTime($name){
        $user = User::where("name", $name)->first();
            
        $user->banning = Carbon::now()->addHour()->addMinute();
        $user->update();
        
    }

    public function resetBanningTime($id){
        $user = User::find($id);
        $user->banning = null;
        $user->update();
    }
}
