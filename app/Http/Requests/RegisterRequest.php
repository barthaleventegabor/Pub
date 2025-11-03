<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            "name" => [ "required", "between:3,6", "unique:users,name", "doesnt_start_with:_"],
            "email" => [ "required", "email", "unique:users,email" ],
            "password" => [ "required", "min:4", "regex:/[a-z]/", "regex:/[A-Z]/", "regex:/[0-9]/"],
            "confirm_password" => [ "required", "same:password"]
        ];
    }

    public function messages() {

        return [

            "name.required" => "Név elvárt",
            "name.between" => "Karakterszám nem megfelelő",
            "name.unique" => "Létező felhasználónév",
            "name.doesnt_start_with" => "Nem kezdődhet alulvonással",
            "email.required" => "Email elvárt",
            "email.email" => "Nem megfelelő email formátum",
            "email.unique" => "Létező email cím",
            "password.required" => "Jelszó elvárt",
            "password.min" => "Jelszó túl rövid",
            "password.regex" => "Kisbetű, nagybetű, szám kötelező",
            "confirm_password.required" => "Jelszót meg kell ismételni",
            "confirm_password.same" => "Jelszavaknak egyeznie kell"
        ];
    }

    public function failedValidation( Validator $validator ) {

        throw new HttpResponseException( response()->json([

            "success" => false,
            "message" => "Adatbeviteli hiba",
            "data" => $validator->errors()
        ]));
    }
}

// same:password, confirmed
