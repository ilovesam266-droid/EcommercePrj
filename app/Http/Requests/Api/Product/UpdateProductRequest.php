<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:active,inactive,pending,rejected',
            'selectedCategories' => 'sometimes|required|array',
            'selectedCategories.*' => 'exists:categories,id',
            'image_ids' => 'sometimes|required|array',
            'image_ids.*' => 'exists:images,id',
        ];
    }
}
