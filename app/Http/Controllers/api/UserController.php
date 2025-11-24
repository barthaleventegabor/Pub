<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function login( LoginRequest $request ) {

        $request->validated();

        if( Auth::attempt([ "name" => $request[ "name" ], "password" => $request[ "password" ]])){

            $actualTime = Carbon::now()->addHour();
            $authUser = Auth::user();
            ( new BannerController )->resetLoginCounter( $authUser->id );
            ( new BannerController )->resetBannedTime( $authUser->id );

            //$token = $authUser->createToken( $authUser->name . "Token" )->plainTextToken;

            $data = [
                "name" => $authUser->name,
                //"token" => $token,
            ];
            return $actualTime;
            //return $this->sendResponse([ "data" => $data, "message" => "Sikeres bejelentkezés" ]);

        } else {

            $counter = ( new BannerController )->getLoginCounter( $request[ "name" ]);
            if( $counter < 3 ){

                ( new BannerController )->setLoginCounter( $request[ "name" ]);

            }else {

                ( new BannerController )->setBannedTime( $request[ "name" ]);
            }

            return $this->sendError( "Autentikációs hiba", [ "Felhasználónév vagy jelszó nem megfelelő" ], 401 );
        }
    }

    public function logout() {

        $user = auth( "sanctum" )->user();
        $name = $user->name;

        $user->currentAccessToken()->delete();

        return $this->sendResponse([ "name" => $name, "Sikeres kijelentkezés" ]);
    }
}
