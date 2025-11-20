<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status' => 'required|in:'.OrderStatus::cases(),
            'total_amount' => 'required|integer|min:0',
            'shipping_fee' => 'required|integer|min:0',
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:15',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'detailed_address' => 'required|string|max:255',
            'payment_method' => 'required|integer|in:'.PaymentMethod::cases(),
            'payment_status' => 'required|integer|in:'.PaymentStatus::cases(),
            'payment_transaction_code' => 'nullable|string|max:100',
            'customer_note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'confirmed_at' => 'nullable|date',
            'shipping_at' => 'nullable|date|after_or_equal:confirmed_at',
            'done_at' => 'nullable|date|after_or_equal:shipping_at',
            'failed_at' => 'nullable|date|after_or_equal:shipping_at',
            'canceled_at' => 'nullable|date|after_or_equal:confirmed_at',
        ];
    }
    public function messages(): array
    {
        return [
            'owner_id.required' => 'The owner field is required.',
            'owner_id.exists' => 'The selected owner does not exist.',

            'status.required' => 'The order status is required.',
            'status.in' => 'Invalid order status value.',

            'total_amount.required' => 'The total amount is required.',
            'total_amount.integer' => 'The total amount must be a number.',
            'total_amount.min' => 'The total amount cannot be negative.',

            'shipping_fee.required' => 'The shipping fee is required.',
            'shipping_fee.integer' => 'The shipping fee must be a number.',
            'shipping_fee.min' => 'The shipping fee cannot be negative.',

            'recipient_name.required' => 'Recipient name is required.',
            'recipient_name.max' => 'Recipient name may not be greater than 100 characters.',

            'recipient_phone.required' => 'Recipient phone number is required.',
            'recipient_phone.regex' => 'Recipient phone number format is invalid.',

            'province.required' => 'Province is required.',
            'district.required' => 'District is required.',
            'ward.required' => 'Ward is required.',
            'detailed_address.required' => 'Detailed address is required.',

            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Invalid payment method value.',

            'payment_status.required' => 'Payment status is required.',
            'payment_status.in' => 'Invalid payment status value.',

            'payment_transaction_code.max' => 'Transaction code may not exceed 100 characters.',

            'confirmed_at.date' => 'Confirmed date must be a valid date.',
            'shipping_at.date' => 'Shipping date must be a valid date.',
            'done_at.date' => 'Done date must be a valid date.',
        ];
    }
}
