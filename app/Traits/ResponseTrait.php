<?php

namespace App\Traits;

trait ResponseTrait {
    
    public function sendResponse( $data, $message = "" ) {

        $response = [

            "data" => $data,
            "message" => $message,
            "success" => true
        ];

        return response()->json( $response, 200 );
    }

    public function sendError( $error, $errorMessage = [], $code = 404 ) {

        $response = [

            "success" => false,
            "error" => $error
        ];

        if( !empty( $errorMessage )) {

            $response[ "errorMessage" ] = $errorMessage;
        }

        return response()->json( $response, $code );
    }
}
