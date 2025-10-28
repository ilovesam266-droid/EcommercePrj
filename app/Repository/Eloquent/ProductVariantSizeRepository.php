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
}
