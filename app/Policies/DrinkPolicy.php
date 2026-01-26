<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Drink;
use Illuminate\Auth\Access\Response;

class DrinkPolicy {
    /**
     * Create a new policy instance.
     */
    public function __construct() {
    }

    public function before( User $user, string $ability ): ?bool {

        //dd( $user );
        if( $user->role === "super" ) {

            return true;
        }

        return null;
    }

    public function viewAny( User $user ) {

        if( $user->isAdmin() && $user->tokenCan( "drinks:read" )) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága a megtekintéshez" );
    }

    public function view( User $user, Drink $drink ): Response {

        if( $user->isAdmin() && $user->tokenCan( "drinks:read" )) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága a megtekintéshez" );
    }

    public function create( User $user ): Response {

        if( $user->isAdmin() && $user->tokenCan( "drinks:create" )) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága az adatfelvételhez" );
    }

    public function update( User $user, Drink $drink ): Response {

        if( $user->isAdmin() && $user->tokenCan( "drinks:update" )) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága a módosításhoz" );
    }

    public function delete( User $user, Drink $drink ) {

        if( $user->isAdmin() && $user->tokenCan( "drinks:delete" )) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága a törléshez" );
    }
}
