<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\Constracts\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }
}
