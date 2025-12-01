<?php

namespace App\Traits;

use App\Models\User;

trait LoginTrait {
    
    protected function checkUser( $name ) {

        $result = User::where( "name", $name )->count();

        if( $result == 1 ) {
            
            return true;

        }else {
            
            return false;
        }
    }

    protected function createToken( $user ) {

        $token = $user->createToken( $user->name . "Token" )->plainTextToken;
            $data = [
            "name" => $user->name,
            "token" => $token,
        ];

        return $data;
    }
}
