<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseTrait;
class AdminController extends Controller
{
    use ResponseTrait;
    public function getUsers() {
        $users = User::all();
        return $this->sendResponse($users,"");
    }

    public function setAdminRole($id) {
        $user = User::find($id);
        $user->role = 2;
        $user->update();

        return $this->sendResponse($user->name,"Admin jog megadva");
    }

    public function delAdminRole($id) {
        $user = User::find($id);
        $user->role = 3;
        $user->update();

        return $this->sendResponse($user->name,"Admin jog elvéve");
    }

    public function newUser(RegisterRequest $request, $role = 3) {

        $request->validated();

        $user = new User();
        $user->name = $request["name"];
        $user->email = $request["email"];
        $user->password = bcrypt($request["password"]);
        $user->role = $role;
        $user->save();

        return $this->sendResponse($user->name,"Felhasználó felvéve");
    }

    public function update(RegisterRequest $request, $id) {
            $response->validate([
                "name" => ["required","between:3,6","unique:users,name","doesnt_start_with:_"],
                "email" => ["required", "email", "unique:users,email"], ],
                [
                "name.required" => "Név elvárt",
                "name.between" => "karakterszám nem megfelel",
                "name.unique" => "létező felhasználó",
                "name.dosent_start_with" => "nem kezdődhet alulvonással",
                "email.required" => "email elvárt",
                "email.email" => "nem jó formátum",
                "emal.unique"=>"létező email",
                ]
            );
    }
    public function setPassword(Request $request, $id){
        $user = User::find($id);
        $user->password = bcrypt($request["password"]);
        $user->update();

        return $this->sendResponse(["user" =>$user, "message"=>"Jelszó sikeresen megváltozott"]);
    }

    public function getTokens() {
        $token = DB::table("personal_access_tokens")->select("name" ,"token")->get();

        return $this->sendResponse(["token"=>$token],"");
    }

    public function destroy($id) {
        $user = User::find($id);
        $user->delete();

        return $this->sendResponse($user->name,"Felhasználó törlve");
    }
}