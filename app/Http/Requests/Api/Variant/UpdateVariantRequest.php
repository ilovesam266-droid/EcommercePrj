<?php

namespace App\Http\Requests\Api\Variant;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'variant_size' => 'sometimes|required|string|max:255',
            'sku' => 'string|max:255|unique:product_variant_sizes,sku',
            'price' => 'sometimes|required|integer|min:1000',
            'total_sold' => 'sometimes|required|integer|min:0',
            'stock' => 'sometimes|required|integer|min:10',
        ];
    }
}
