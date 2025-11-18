<?php

namespace App\Http\Requests\Api\Variant;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreVariantRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'variant_size' => 'required|string|max:255',
            'sku' => 'string|max:255|unique:product_variant_sizes,sku',
            'price' => 'required|integer|min:1000',
            'total_sold' => 'required|integer|min:0',
            'stock' => 'required|integer|min:10',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }
}
