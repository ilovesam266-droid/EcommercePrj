<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'recipient_name'  => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'province'        => $this->province,
            'district'        => $this->district,
            'ward'            => $this->ward,
            'detailed_address'=> $this->detailed_address,
            'is_default'      => (bool) $this->is_default,
            'created_at'      => $this->created_at?->toDateTimeString(),
            'updated_at'      => $this->updated_at?->toDateTimeString(),
        ];
    }
}
