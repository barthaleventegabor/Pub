<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\api\ResponseController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Traits\BanningTrait;
use App\Traits\ResponseTrait;
use App\Traits\LoginTrait;

class UserController extends Controller
{
    use ResponseTrait,BanningTrait,LoginTrait;

    public function register(RegisterRequest $request){
        $validated = $request->validated();

        $user = new User();
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->password = bcrypt($validated["password"]);

        $user->save();

        return $this->sendResponse($user->name,"Sikeres regisztráció");
    }
    public function login(LoginRequest $request){

        $validated = $request->validated();

        if(Auth::attempt(["name"=>$request["name"],"password"=>$request["password"]])){

            
            $actualTime = Carbon::now()->addHour();
            $authUser = Auth::user();
            $banningTime = $authUser->banning;
            if($banningTime < $actualTime){
    
                $this->resetLoginCounter($authUser);
                $this->resetBanningTime($authUser);
                $data = $this->createToken($authUser);

                return $this->sendResponse(["data"=>$data,"message"=>"Sikeres bejelentkezés"]);
                }
            else{
                return $this->sendError("Tiltott belépés",["A következő lehetőség:  ".$banningTime],423);
            }
        }else{
            if($this->checkUser($validated["name"])){
                $counter = $this->getLoginCounter($validated["name"]);
                if($counter < 3){
                    $this->setLoginCounter($validated["name"]);
                }else{
                    $this->setBanningTime($validated["name"]);
                }   
            }

            return $this->sendError("Autentikációs hiba",["Felhasználónev vagy jelszó nem megfelelő"],401);
        }
    }

    
    public function logout(){
        $user = auth("sanctum")->user();
        $name = $user->name;
        $user->currentAccessToken()->delete();
        return $this->sendResponse(["name"=>$name,"message"=>"Sikeres kijelentkezés"]);
    }
}