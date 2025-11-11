<?php

namespace App\Repository\Eloquent;

use App\Models\Review;
use App\Repository\Constracts\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function getModel()
    {
        return Review::class;
    }

    public function getFilteredReview(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($filter, $search) {
            if (!empty($filter['status'])) {
                $query->where('status', $filter['status']);
            }

            if (!empty($filter['rating'])) {
                $query->where('rating', $filter['rating']);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('username', 'like', '%' . $search . '%');
                    });

                    $q->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('slug', 'like', '%' . $search . '%');
                    });

                    $q->orWhere('body', 'like', '%' . $search . '%');
                });
            }
        };
    }
}
