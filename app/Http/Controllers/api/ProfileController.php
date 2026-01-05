<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Traits\ResponseTrait;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller {
    
    use ResponseTrait;

    public function getProfile( Request $request, $id ) {

        $profile = UserProfile::with( "user" )->where( "user_id", $id )->first();

        return $this->sendResponse(( new ProfileResource( $profile )));
    }
}
