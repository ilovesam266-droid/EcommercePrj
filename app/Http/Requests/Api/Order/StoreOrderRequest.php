<?php

namespace App\Http\Requests\Api\Order;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'customer_note' => 'nullable|string',
            'admin_note' => 'nullable|string',

            'payment_method' => ['required', Rule::in(array_map(fn($case) => $case->value, PaymentMethod::cases()))],


            'cart_item_ids'    => ['required_without:variant_id,qty', 'array', 'min:1'],
            'cart_item_ids.*'  => ['integer', 'distinct', 'exists:cart_items,id'],

            'variant_id' => ['integer', 'required_without:cart_item_ids'],
            'qty' => ['integer', 'required_without:cart_item_ids', 'min:1'],
        ];
    }
}
