<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserController extends ResponseController {

    public function register( RegisterRequest $request ) {

        $request->validated();

        // $user = User::create([
        //     "name" => $request[ "name" ],
        //     "email" => $request[ "email" ],
        //     "password" => $request[ "password" ]
        // ]);

        $user = new User();
        $user->name = $request[ "name" ];
        $user->email = $request[ "email" ];
        $user->password = bcrypt( $request[ "password" ]);

        $user->save();

        return $this->sendResponse( $user->name, "Sikeres regisztáció" );
    }

    public function login() {

    }

    public function logout() {

    }
}
