<?php

namespace App\Repository\Eloquent;

use App\Models\Mail;
use App\Models\Order;
use App\Repository\Constracts\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function getFilteredOrder(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($filter, $search) {
            if (!empty($filter['status'])) {
                $query->where('status', $filter['status']);
            }

            if (!empty($filter['payment_method'])) {
                $query->whereHas('payment', function ($q) use ($filter) {
                    $q->where('payment_method', $filter['payment_method']);
                });
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {

                    $q->whereHas('owner', function ($ownerQuery) use ($search) {
                        $ownerQuery->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('username', 'like', '%' . $search . '%');
                    });
                    $q->orWhere('province', 'like', '%' . $search . '%')
                        ->orWhere('district', 'like', '%' . $search . '%')
                        ->orWhere('ward', 'like', '%' . $search . '%')
                        ->orWhere('detailed_address', 'like', '%' . $search . '%');
                });
            }
        };
    }
}
