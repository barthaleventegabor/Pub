<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class DrinkUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            "drink" => [
                "required", "alpha_num", "between:3,15" //"max:15", "min:3"
            ],
            "amount" => [
                "required", "max_digits:3" //"digits_between:3,5", "numeric","decimal:0,4"
            ],
            "price" => [
                "required", "numeric"
            ],
            "type" => [
                "required", "alpha_num", "between:3,15"
            ],
            "package" => [
                "required", "alpha_num", "between:3,15"
            ],

        ];
    }

    public function messages() {

        return [
            "drink.required" => "Mező elvárt",
            "drink.alpha_num" => "Csak betűk és számok lehetnek",
            "drink.between" => "Túl kevés vagy sok karakter",

            "amount.required" => "Mező elvárt",
            "amount.max_digits" => "Túl nagy szám",

            "price.required" => "Mező elvárt",
            "price.numeric" => "Csak szám lehet",

            "type.required" => "Mező elvárt",
            "type.alpha_num" => "Csak betűk és számok lehetnek",
            "type.between" => "Túl kevés vagy sok karakter",

            "package.required" => "Mező elvárt",
            "package.alpha_num" => "Csak betűk és számok lehetnek",
            "package.between" => "Túl kevés vagy sok karakter"
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
