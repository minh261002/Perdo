<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }
}
