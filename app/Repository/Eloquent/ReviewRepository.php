<?php

namespace App\Repository\Eloquent;

use App\Enums\ReviewStatus;
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

    public function isExists($user_id, $product_id, $order_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->where('order_id', $order_id)
            ->exists();
    }

    public function getReviewByUser(int $userId){
        return $this->model->where('user_id', $userId);
    }

    public function total(): int
    {
        return $this->model->count();
    }

    /**
     * Take review approved
     */
    public function approvedCount(): int
    {
        return $this->model
            ->where('status', ReviewStatus::Approved)
            ->count();
    }

    /**
     * Take review pending
     */
    public function pendingCount(): int
    {
        return $this->model
            ->where('status', ReviewStatus::Pending)
            ->count();
    }

    /**
     * Take review rating low (≤ threshold)
     */
    public function lowRatingCount(int $threshold = 2): int
    {
        return $this->model
            ->where('rating', '<=', $threshold)
            ->count();
    }
}
