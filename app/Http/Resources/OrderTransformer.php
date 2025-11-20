<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'owner_id' => $this->owner_id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'shipping_fee' => $this->shipping_fee,
            'recipient_name' => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'province' => $this->province,
            'district' => $this->district,
            'ward' => $this->ward,
            'detailed_address' => $this->detailed_address,
            'customer_note' => $this->customer_note,
            'cancellation_reason' => $this->cancellation_reason,
            'failure_reason' => $this->failure_reason,
            'confirmed_at' => $this->confirmed_at,
            'shipping_at' => $this->shipping_at,
            'done_at' => $this->done_at,
            'canceled_at' => $this->canceled_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
