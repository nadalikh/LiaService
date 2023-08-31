<?php

namespace App\Http\Requests\Stores;

use App\Consts\Validations;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => Validations::REQUIRED . "|" . Validations::EMAIL ."|". Validations::USER_UNIQUE,
            "password" => Validations::REQUIRED . "|" . Validations::PASSWORD,
            "name" => Validations::REQUIRED ."|". Validations::STRING
        ];
    }
}
