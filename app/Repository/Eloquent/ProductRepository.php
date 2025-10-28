<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\Constracts\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }
}
