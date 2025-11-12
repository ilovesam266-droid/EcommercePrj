<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(string $type = 'create', $id = null): array
    {
        $rules = [
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

        if($type !== 'create' && $id){
            $rules['name'] = [
                'required',
                'string',
                'max:100',
                'unique:categories,name,'.$id ,
            ];
        }

        return $rules;
    }

    /**
     * Custom error messages (optional)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name already exists',
            'slug.unique' => 'Slug already exists',
            'slug.alpha_dash' => 'Slug may only contain letters, numbers, dashes, and underscores',
        ];
    }
}
