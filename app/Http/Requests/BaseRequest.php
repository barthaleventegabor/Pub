<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ResponseTrait;

abstract class BaseRequest extends FormRequest {

    use ResponseTrait;

    public function baseRules(): array {

        return [
            //
        ];
    }

    public function failedValidation( Validator $validator ) {

        $response = $this->sendValidationError( $validator->errors() );

        throw new HttpResponseException( $response );
    }
}
