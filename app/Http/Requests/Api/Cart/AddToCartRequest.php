<?php

namespace App\Http\Requests\Api\Cart;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddToCartRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function authorize(): bool
    {
        // Only authenticated users can add items to the cart
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'variant_id' => 'required|exists:product_variant_sizes,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'variant_id.required' => 'Please select a product variant.',
            'variant_id.exists' => 'The selected product variant does not exist.',
            'quantity.required' => 'Please enter the quantity.',
            'quantity.integer' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity must be greater than 0.',
        ];
    }
}
