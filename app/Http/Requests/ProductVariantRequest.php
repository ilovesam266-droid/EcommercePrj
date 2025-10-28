<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
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
            'variant_size' => 'required|string|max:255',  // Kiểm tra variant_size là chuỗi và không quá 255 ký tự
            'sku' => 'string|max:255|unique:product_variants,sku', // Kiểm tra sku phải duy nhất trong bảng product_variants
            'price' => 'required|integer|min:1000', // Kiểm tra price phải là số nguyên và >= 0
            'total_sold' => 'required|integer|min:0', // Kiểm tra total_sold phải là số nguyên và >= 0
            'stock' => 'required|integer|min:10',
        ];
    }
    public function messages(): array
    {
        return [
            'variant_size.required' => 'Please provide a size for the product variant.',
            'variant_size.string' => 'The variant size must be a string.',
            'variant_size.max' => 'The variant size cannot exceed 255 characters.',
            'sku.string' => 'The SKU must be a string.',
            'sku.max' => 'The SKU cannot exceed 255 characters.',
            'sku.unique' => 'This SKU already exists, please choose another one.',
            'price.required' => 'Please enter the price for the product.',
            'price.integer' => 'The price must be an integer.',
            'price.min' => 'The price cannot be less than 1000.',
            'total_sold.required' => 'Please enter the total sold quantity.',
            'total_sold.integer' => 'The total sold quantity must be an integer.',
            'total_sold.min' => 'The total sold quantity cannot be less than 0.',
            'stock.required' => 'Please enter the stock quantity.',
            'stock.integer' => 'The stock quantity must be an integer.',
            'stock.min' => 'The stock quantity cannot be less than 10.',
        ];
    }
}
