<?php

namespace App\Services;

use App\Models\User;
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
        //$user->password = bcrypt( $data[ "password" ]);
        $user->password = Hash::make( $data[ "password" ]);

        $user->save();

        return $this->sendResponse( $user->name, "Sikeres regisztráció." );
    }
}
