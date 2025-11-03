<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class AdminController extends ResponseController {

    public function getUsers() {

        $users = User::all();

        return $this->sendResponse( $users, "" );
    }

    public function setAdminRole( $id ) {

        $user = User::find( $id );

        $user->role = 2;
        $user->update();

        return $this->sendResponse( $user->name, "Admin jog megadva" );
    }

    public function delAdminRole( $id ) {

        $user = User::find( $id );

        $user->role = 3;
        $user->update();

        return $this->sendResponse( $user->name, "Admin jog elvéve" );
    }

    public function newUser( RegisterRequest $request, $role = 3 ) {

        $request->validated();

        $user = new User();
        $user->name = $request[ "name" ];
        $user->email = $request[ "email" ];
        $user->password = bcrypt( $request[ "password" ]);
        $user->role = $role;

        $user->save();

        return $this->sendResponse( $user->name, "Felhasználó felvéve" );
    }

    public function update( Request $request ) {

        $response->validate([
            "name" => [ "required", "between:3,6", "unique:users,name", "doesnt_start_with:_" ],
            "email" => [ "required", "email", "unique:users,email" ]
            ],
            [
                "name.required" => "Név elvárt",
                "name.between" => "Karakterszám nem megfelelő",
                "name.unique" => "Létező felhasználónév",
                "name.doesnt_start_with" => "Nem kezdődhet alulvonással",
                "email.required" => "Email elvárt",
                "email.email" => "Nem megfelelő email formátum",
                "email.unique" => "Létező email cím",
            ]
        );
    }

    public function destroy() {


    }
}
