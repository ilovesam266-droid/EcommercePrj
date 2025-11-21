<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsTransformer extends JsonResource
{
    protected $variants;

    public function __construct($resource, $variants)
    {
        parent::__construct($resource);
        $this->variants = $variants;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
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

            'reviews' => $this->reviews->map(function ($review) {
                return [
                    'created_by' => $review->user_id,
                    'rating'     => $review->rating,
                ];
            }),

            'variants' => $this->variants,
        ];
    }
}
