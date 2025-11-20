<?php

namespace App\Http\Requests\Api\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:15',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'detailed_address' => 'required|string|max:255',
            // 'payment_method' => 'required|integer|in:'.PaymentMethod::cases(),
            // 'payment_status' => 'required|integer|in:'.PaymentStatus::cases(),
            // 'payment_transaction_code' => 'nullable|string|max:100',
            'customer_note' => 'nullable|string',
            'admin_note' => 'nullable|string',

            'payment_method' => 'required|in:cod,banking,momo,vnpay,zalopay',

            'items' => 'required|array|min:1',
            'items.*.variant_id' => 'required|exists:product_variant_sizes,id',
            'items.*.qty' => 'required|integer|min:1',
        ];
    }
}
