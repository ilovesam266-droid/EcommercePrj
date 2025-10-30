<?php

namespace App\Repository\Eloquent;

use App\Models\OrderItem;
use App\Repository\Constracts\OrderItemRepositoryInterface;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
    public function getModel()
    {
        return OrderItem::class;
    }
}
