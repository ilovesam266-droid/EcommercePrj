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

    public function getFilteredProduct(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($filter, $search) {
            if (!empty($filter['status'])) {
                // $this->buildCriteria($query, $filter);
                $query->where('status', $filter['status']);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')

                        ->orwhereHas('creator', function ($creatorQuery) use ($search) {
                            $creatorQuery->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%')
                                ->orWhere('username', 'like', '%' . $search . '%');
                        });
                });
            }
        };
    }

    public function getAllProducts($perPage, $sort, array $filter = [], ?string $search = null)
    {
        return $this->all(
            $this->getFilteredProduct($filter, $search),
            ['created_at' => $sort],
            $perPage,
            ['*'],
            [
                'images' => function ($query) {
                    $query->wherePivot('is_primary', true);
                },
                'categories',
                'reviews' => function ($query) {
                    $query->select('product_id', 'user_id', 'rating');
                },
                'creator'
            ],
            false
        );
    }

    public function getProduct(int $productId){
        return $this->find($productId,
                ['images',
                'categories',
                'reviews' => function ($query) {
                    $query->select('product_id','user_id', 'rating');
                },
                'creator',
                'variant_sizes',
            ]);
    }
}
