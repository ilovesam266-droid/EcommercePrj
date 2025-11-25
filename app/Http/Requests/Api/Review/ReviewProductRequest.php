<?php

namespace App\Http\Requests\Api\Review;

use App\Http\Requests\Api\ApiFormRequest;
use Illuminate\Validation\ValidationException;

class ReviewProductRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $productId = $this->route('product');

        $hasPurchased = $user->orders()
            ->whereNull('deleted_at')
            ->whereHas('orderItems', function ($q) use ($productId) {
                $q->whereNull('deleted_at')
                    ->whereHas('productVariantSize.product', function ($qq) use ($productId) {
                        $qq->where('id', $productId);
                    });
            })
            ->exists();

        return $hasPurchased;
    }

    protected function failedAuthorization()
    {
        throw ValidationException::withMessages([
            'product_id' => 'You just can review your product purchased.',
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'body'       => ['required', 'string', 'max:1000'],
            'order_id'   => ['required', 'integer', 'exists:orders,id']
        ];
    }
}
