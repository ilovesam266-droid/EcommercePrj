<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'selectedCategories' => 'required|array',
            'selectedCategories.*' => 'exists:categories,id',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'content.required' => 'The body field is required.',
            'selectedCategories.required' => 'Category name is required.',
            'selectedCategories.array' => 'Categories must be an array.',
            'selectedCategories.*.exists' => 'The selected category does not exist in the system.',
        ];
    }
}
