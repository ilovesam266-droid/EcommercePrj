<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends ApiFormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'created_by' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending,rejected',
            'selectedCategories' => 'required|array',
            'selectedCategories.*' => 'exists:categories,id',
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:images,id',
        ];
    }
}
