<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'images.*' => 'image|max:5120',
            'type' => 'required|in:products,blogs',
        ];
    }
    public function messages(): array
    {
        return [
            'images.*.image' => 'The file must be a valid image.',
            'images.*.max' => 'The image size must not exceed 5MB.',
            'type.required' => 'Please select a category.',
            'type.in' => 'The selected category is invalid.',
        ];
    }
}
