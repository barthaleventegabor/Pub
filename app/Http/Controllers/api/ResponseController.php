<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public function sendResponse($data, $message){
        $response = [
            "data" => $data,
            "message" =>$message,
            "success" => true
        ];
        return response()->json($response,200);
    }

    

    public function sendError(){

    }
}
