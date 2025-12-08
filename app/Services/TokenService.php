<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ResponseTrait;

class TokenService {

    use ResponseTrait;
    
    public function __construct() {
    }

    public function generateToken( $user ) {

        $token = $user->createToken( $user->name . "Token" )->plainTextToken;
            
        return $token;
    }

    public function deleteToken( $user ) {

        $success = $user->currentAccessToken()->delete();

        if( !$success ) {

            return $this->sendError( "Végrehajtási hiba", [ "Hiba a kijelentkezés során.", 422 ]);
        }
        
        return $this->sendResponse([ "name" => $user->name, "Sikeres kijelentkezés" ]);
    }
}
