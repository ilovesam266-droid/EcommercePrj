<?php

namespace App\Repository\Eloquent;

use App\Models\ProductVariantSize;
use App\Repository\Constracts\ProductVariantSizeRepositoryInterface;

class ProductVariantSizeRepository extends BaseRepository implements ProductVariantSizeRepositoryInterface
{
    public function getModel()
    {
        return ProductVariantSize::class;
    }

    public function getFilteredVariant(?string $search = null){
        return function ($query) use ($search){
            if(!empty($search)){
                $query->whereHas('product', function ($variantProduct) use ($search){
                    $variantProduct->where('name', $search)
                        ->orWhere('slug', $search);
                });
            }
        };
    }

    public function getByIdsForUpdate(array $variantIds)
    {
        return ProductVariantSize::whereIn('id', $variantIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }

    public function reduceStock($variantId, $qty){
        return ProductVariantSize::where('id', $variantId)
            ->where('stock', '>=', $qty)
            ->decrement('stock', $qty);
    }

    public function getAllVariant($perPage, $sort, $search){
        return $this->all(
            $this->getFilteredVariant($search),
            ['created_at' => $sort],
            $perPage,
            ['*'],
            [],
            false
        );
    }
}
