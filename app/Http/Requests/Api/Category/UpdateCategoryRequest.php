<?php

namespace App\Http\Requests\Api\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name,' ,
            ],
            'slug' => [
                'string',
                'max:100',
                'unique:categories,slug,',
                'alpha_dash', // letters, numbers, dashes and underscores only
            ],
        ];
    }
}
