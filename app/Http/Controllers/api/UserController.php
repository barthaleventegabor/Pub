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
use App\Traits\LoginTrait;

class UserController extends Controller {

    use BanningTrait, ResponseTrait, LoginTrait;

    public function register( RegisterRequest $request ) {

        $validated = $request->validated();

        $user = new User();
        $user->name = $validated[ "name" ];
        $user->email = $validated[ "email" ];
        $user->password = bcrypt( $validated[ "password" ]);

        $user->save();

        return $this->sendResponse( $user->name, "Sikeres regisztáció" );
    }

    public function login( LoginRequest $request ) {

        
        $validated = $request->validated();

        if( Auth::attempt([ "name" => $validated[ "name" ], "password" => $validated[ "password" ]])){

            $actualTime = Carbon::now()->addHour();
            $authUser = Auth::user();
            
            if( $actualTime > $authUser->banning ) {

                $this->resetLoginCounter( $authUser );
                $this->resetBannedTime( $authUser );
                $data = $this->createToken( $authUser );

                return $this->sendResponse([ "data" => $data, "message" => "Sikeres bejelentkezés" ]);
            
            }else {

                return $this->sendError( "Tiltott belépés", [ "Következő lehetőség:", $banningTime ], 423 );
            }
        } else {

            if( $this->checkUser( $validated[ "name" ]) ) {

                $counter = $this->getLoginCounter( $validated[ "name" ]);
                if( $counter < 3 ){

                    $this->setLoginCounter( $validated[ "name" ]);

                }else {

                    $this->setBannedTime( $validated[ "name" ]);
                }
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
