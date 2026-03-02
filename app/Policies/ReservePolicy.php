<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reserve;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class ReservePolicy {
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function before( User $user, string $ability ) {

        if( $user->isAdmin() ) {

            return true;
        }

        return null;
    }

    public function viewAny( ?User $user ) {

        return Response::allow();
    }

    public function view( User $user, Reserve $reserve ): Response {

        if( $user->tokenCan( "reserves:read" ) && $user->id === $reserve->user_id ) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága ehhez a művelethez" );
    }

    public function create( User $user ) {

        if( $user->tokenCan( "reserves:create" )) {

            return Response::allow();
        }

        return Response::deny( "Nincs jogosultsága ehhez a művelethez" );
    }

    public function update( User $user, Reserve $reserve ) {

        if( $user->tokenCan( "reserves:update" ) && $user->id === $reserve->user_id ) {

            return Response::allow();

        }

        return Response::deny( "Nincs jogosultsága ehhez a művelethez" );
    }

    public function delete( User $user, Reserve $reserve ) {

        if( $user->tokenCan( "reserves:delete" ) && $user->id === $reserve->user_id ) {

            return Response::allow();

        }

        return Response::deny( "Nincs jogosultsága ehhez a művelethez" );
    }
}
