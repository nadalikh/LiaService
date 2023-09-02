<?php

namespace App\Http\Requests\Updates;

use App\Consts\Validations;
use App\Rules\ProductExistence;
use App\Rules\ProductQuantityInOrder;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }
    protected function failedAuthorization()
    {
        throw new AuthenticationException( response()->json(["errors" => "unauthorized"], 403));
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
            "products_quantity.*.quantity" => Validations::POSITIVE_NUMBER,
            "products_quantity" => [Validations::REQUIRED , Validations::ARRAY, new ProductExistence(), new ProductQuantityInOrder()],
        ];
    }
}
