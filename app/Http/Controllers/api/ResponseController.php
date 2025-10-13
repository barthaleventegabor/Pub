<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseController extends Controller {

    public function sendResponse( $data, $message ) {

        $response = [

            "data" => $data,
            "message" => $message,
            "success" => true
        ];

        return response()->json( $response, 200 );
    }

    public function sendError() {


    }
}
