<?php

namespace App\Repositories\Brand;

use App\Repositories\BaseRepository;
use App\Models\Brand;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function getModel()
    {
        return Brand::class;
    }
}
