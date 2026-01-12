<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ResponseTrait;

class TokenService {

    use ResponseTrait;
    protected AbilityService $abilityService;

    public function __construct( AbilityService $abilityService ) {

        $this->abilityService = $abilityService;
    }

    public function generateToken( $user ) {

        if( $user->role == "admin" ) {

            return $user->createToken( $user->name . "Token", $this->abilityService->createAdminAbilities() )->plainTextToken;

        }else if( $user->role == "user" ){

            return $user->createToken( $user->name . "Token", $this->abilityService->createUserAbilities()  )->plainTextToken;
        
        }else {

            return $user->createToken( $user->name . "Token" )->plainTextToken;
        }
    }

    public function deleteToken( $user ) {

        $success = $user->currentAccessToken()->delete();

        if( !$success ) {

            return $this->sendError( "Végrehajtási hiba", [ "Hiba a kijelentkezés során.", 422 ]);
        }
        
        return $this->sendResponse([ "name" => $user->name, "Sikeres kijelentkezés" ]);
    }
}
