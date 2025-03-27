<?php

namespace App\Repositories\Discount;

use App\Repositories\BaseRepository;
use App\Models\DiscountApplication;

class DiscountApplicationRepository extends BaseRepository implements DiscountApplicationRepositoryInterface
{
    public function getModel()
    {
        return DiscountApplication::class;
    }
}