<?php

namespace App\Http\Requests\Api\Cart;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }
}
