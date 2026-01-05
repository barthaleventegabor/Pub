<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseTrait;

class RegisterService {

    use ResponseTrait;

    public function __construct(){
    }

    public function create( array $data ) {

        $user = new User();
        $user->name = $data[ "name" ];
        $user->email = $data[ "email" ];
        $user->role = "user";
        //$user->password = bcrypt( $data[ "password" ]);
        $user->password = Hash::make( $data[ "password" ]);

        //$user->save();

        $profile = new UserProfile();
        $profile->full_name = $data[ "full_name" ];
        $profile->city = $data[ "city" ];
        $profile->address = $data[ "address" ];
        $profile->phone = $data[ "phone" ];
        $profile->user_id = $user->id;

        //$profile->save();

        return $this->sendResponse( $data, "Sikeres regisztráció." );
    }
}
