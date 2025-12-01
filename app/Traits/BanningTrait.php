<?php

namespace App\Traits;
use App\Models\User;
use Carbon\Carbon;

trait BanningTrait
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

    public function setBanningTime($name){
        $user = User::where("name", $name)->first();
            
        $user->banning = Carbon::now()->addHour()->addMinute();
        $user->update();
        
    }

    public function resetLoginCounter($user)
    {
        $user->counter = 0;
        $user->update();
    }

    public function resetBanningTime($user){
        
        $user->banning = null;
        $user->update();
    }

    public function getBanningTime($user){

        return  $user->banning;
        
    }


}
