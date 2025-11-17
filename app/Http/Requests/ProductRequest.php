<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,pending,rejected',
            'selectedCategories' => 'required|array',
            'selectedCategories.*' => 'exists:categories,id',
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:images,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be a string.',
            'name.max' => 'Product name may not exceed 255 characters.',

            'description.string' => 'Product description must be a string.',

            'status.required' => 'Status is required.',

            'selectedCategories.required' => 'Category name is required.',
            'selectedCategories.array' => 'Categories must be an array.',
            'selectedCategories.*.exists' => 'The selected category does not exist in the system.',

            'image_ids.required' => 'Image is required.',
            'image_ids.array' => 'Image list must be an array.',
            'image_ids.*.exists' => 'The selected image does not exist in the system.',

        ];
    }
}
