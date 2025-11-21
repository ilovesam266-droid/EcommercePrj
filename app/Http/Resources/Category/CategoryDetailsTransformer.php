<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\ProductTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailsTransformer extends JsonResource
{
    protected $products;
    public function __construct($resource, $products)
    {
        parent::__construct($resource);
        $this->products = $products;
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

            'products' =>  $this->products,
        ];
    }
}
