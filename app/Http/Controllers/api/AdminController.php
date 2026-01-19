<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseTrait;

class AdminController extends Controller {

    use ResponseTrait;
    
    public function getUsers() {

        //Resourse állományt megírni
        $users = UserProfile::with( "users" );

        return $this->sendResponse( $users, "" );
    }

    public function setAdminRole( User $user ) {

        $user->role = "admin";
        $user->update();

        return $this->sendResponse( $user->name, "Admin jog megadva" );
    }

    public function delAdminRole( User $user ) {

        $user->role = "user";
        $user->update();

        return $this->sendResponse( $user->name, "Admin jog elvéve" );
    }

    public function createUser( RegisterRequest $request ) {

        $validated = $request->validated();

        $user = new User();
        $user->name = $validated[ "name" ];
        $user->email = $validated[ "email" ];
        $user->password = bcrypt( $validated[ "password" ]);
        $user->role = "user";
        
        $user->save();

        $userProfile = new UserProfile();
        $userProfile->fullname = $request[ "full_name" ];
        $userProfile->city = $request[ "city" ];
        $userProfile->address = $request[ "address" ];
        $userProfile->phone = $request[ "phone" ];
        $userProfile->user_id = $user->id;

        $userProfile->save();

        return $this->sendResponse( $user->name, "Felhasználó felvéve" );
    }

    public function update( Request $request ) {

        //Request állományt megírni, users->password írható
        $request->validate([
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

    public function setPassword( Request $request, User $user ) {

        //Request állomány
        $user->password = bcrypt( $request[ "password" ]);

        $user->update();

        return this->sendResponse([ "user" => $user, "message" => "Jelszó sikeresen megváltozott" ]);
    }

    public function getTokens() {

        $token = DB::table( "personal_access_tokens" )->select( "name", "token" )->get();

        return $this->sendResponse([ "token" => $token ], "" );
    }

    public function destroy() {


    }
}
