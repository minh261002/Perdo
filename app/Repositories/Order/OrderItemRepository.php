<?php

namespace App\Repositories\Order;

use App\Repositories\BaseRepository;
use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
    public function getModel()
    {
        return OrderItem::class;
    }
}