<?php

namespace App\Repositories\Discount;

use App\Repositories\BaseRepository;
use App\Models\Discount;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    public function getModel()
    {
        return Discount::class;
    }
}
