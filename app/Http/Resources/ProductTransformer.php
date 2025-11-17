<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTransformer extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'status'      => $this->status,
            'created_by'  => $this->created_by,
            'created_at'  => $this->created_at?->toDateTimeString(),
            'updated_at'  => $this->updated_at?->toDateTimeString(),

            'images' => $this->images->map(function ($image) {
                return [
                    'id'         => $image->id,
                    'name'       => $image->name,
                    'url'        => $image->url,
                    'is_primary' => $image->pivot->is_primary ?? 0,
                    'order'      => $image->pivot->order_of_images ?? 0,
                ];
            }),

            'categories' => $this->categories->map(function ($category) {
                return [
                    'id'   => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            }),

            'creator' => $this->creator ? [
                'id'         => $this->creator->id,
                'first_name' => $this->creator->first_name,
                'last_name'  => $this->creator->last_name,
                'username'   => $this->creator->username,
                'email'      => $this->creator->email,
                'avatar'     => $this->creator->avatar,
                'role'       => $this->creator->role,
                'status'     => $this->creator->status,
            ] : null,

            'reviews' => $this->reviews->map(function ($review) {
                return [
                    'product_id' => $review->product_id,
                    'rating'     => $review->rating,
                ];
            }),
        ];
    }
}
