<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\BanningService;
use App\Services\RegisterService;
use App\Services\TokenService;
use App\Traits\ResponseTrait;

class UserController extends Controller {

    use ResponseTrait;

    protected BanningService $banningService;
    protected RegisterService $registerService;
    protected TokenService $tokenService;

    public function __construct( BanningService $banning, RegisterService $registerService, TokenService $tokenService ) {

        $this->banningService = $banning;
        $this->registerService = $registerService;
        $this->tokenService = $tokenService;
    }

    public function register( RegisterRequest $request ) {

        $validated = $request->validated();

        return $this->registerService->create( $validated );
    }

    public function login( LoginRequest $request ) {

        
        $validated = $request->validated();

        if( Auth::attempt([ "name" => $validated[ "name" ], "password" => $validated[ "password" ]])){

            $actualTime = Carbon::now()->addHour();
            $authUser = Auth::user();
            
            if( $actualTime > $authUser->banning ) {

                $this->banningService->resetLoginCounter( $authUser );
                $this->banningService->resetBannedTime( $authUser );
                $token = $this->tokenService->generateToken( $authUser );

                $response =  [

                    "name" => $authUser->name,
                    "token" => $token,
                ];
                return $this->sendResponse([ $response, "message" => "Sikeres bejelentkezés" ]);
            
            }else {

                return $this->sendError( "Tiltott belépés", [ "Következő lehetőség:", $authUser->banning ], 423 );
            }
        } else {

            if( $this->checkUser( $validated[ "name" ]) ) {

                $counter = $this->banningService->getLoginCounter( $validated[ "name" ]);
                if( $counter < 3 ){

                    $this->banningService->setLoginCounter( $validated[ "name" ]);

                }else {

                    $this->banningService->setBannedTime( $validated[ "name" ]);
                }
            }
            
            return $this->sendError( "Autentikációs hiba", [ "Felhasználónév vagy jelszó nem megfelelő" ], 401 );
        }
    }

    public function logout() {

        $user = auth( "sanctum" )->user();
        
        return $success = $this->tokenService->deleteToken( $user );
    }
}
