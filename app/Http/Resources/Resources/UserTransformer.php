<?php

namespace App\Http\Resources\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only([
            'id',
            'first_name',
            'last_name',
            'username',
            'email',
            'role',
            'status',
            'created_at',
            'updated_at',
        ]);
    }
}
