<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\api\ResponseController;

class DrinkRequest extends BaseRequest {

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
    public function rules(): array
    {
        return [

            "drink" => [
                "required", "alpha_num", "between:3,15", "unique:drinks" //"max:15", "min:3"
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
}