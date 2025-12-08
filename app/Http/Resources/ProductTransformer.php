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
            'price'       => $this->variant_sizes->min('price') ?? 100000,
            'stock'       => $this->sumStock(),
            'description' => $this->description,
            'status'      => $this->status,
            'created_by'  => $this->created_by,
            'created_at'  => $this->created_at?->toDateTimeString(),
            'updated_at'  => $this->updated_at?->toDateTimeString(),

            'images' => $this->images->map(function ($image) {
                return [
                    'name'       => $image->name,
                    'url'        => $image->url,
                    'is_primary' => $image->pivot->is_primary ?? 0,
                    'order'      => $image->pivot->order_of_images ?? 0,
                ];
            }),

            'categories' => $this->categories->map(function ($category) {
                return [
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            }),

            'reviews' =>
            [
                'rating' => round($this->averageRating(), 1),
                'num_rate' => $this->reviews->count(),
            ]
        ];
    }
}
