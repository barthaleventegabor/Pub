<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Traits\BanningTrait;
use App\Traits\ResponseTrait;

class UserController extends Controller {

    use BanningTrait, ResponseTrait;

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
            $banningTime = $authUser->banning;
            
            if( $actualTime > $banningTime ) {

                $this->resetLoginCounter( $authUser );
                $this->resetBannedTime( $authUser );
                //$token = $authUser->createToken( $authUser->name . "Token" )->plainTextToken;
                $data = [
                "name" => $authUser->name,
                //"token" => $token,
                ];

                return $this->sendResponse([ "data" => $data, "message" => "Sikeres bejelentkezés" ]);
            
            }else {

                return $this->sendError( "Tiltott belépés", [ "Következő lehetőség:", $banningTime ], 423 );
            }
        } else {

            $counter = $this->getLoginCounter( $request[ "name" ]);
            if( $counter < 3 ){

                $this->setLoginCounter( $request[ "name" ]);

            }else {

                $this->setBannedTime( $request[ "name" ]);
            }

            return $this->sendError( "Autentikációs hiba", [ "Felhasználónév vagy jelszó nem megfelelő" ], 401 );
        }
    }

    private function loginError( $name ) {


    }

    public function logout() {

        $user = auth( "sanctum" )->user();
        $name = $user->name;

        $user->currentAccessToken()->delete();

        return $this->sendResponse([ "name" => $name, "Sikeres kijelentkezés" ]);
    }
}
