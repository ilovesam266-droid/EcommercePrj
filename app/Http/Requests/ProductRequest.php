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
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',

            'status.required' => 'Trạng thái là bắt buộc.',

            'selectedCategories.required' => 'Tên danh mục là bắt buộc.',
            'selectedCategories.array' => 'Danh mục phải là một mảng.',
            'selectedCategories.*.exists' => 'Danh mục đã chọn không tồn tại trong hệ thống.',

            'image_ids.required' => 'ảnh là bắt buộc.',
            'image_ids.array' => 'Danh sách ảnh phải là một mảng.',
            'image_ids.*.exists' => 'Ảnh đã chọn không tồn tại trong hệ thống.',
        ];
    }
}
