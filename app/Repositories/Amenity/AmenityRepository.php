<?php

namespace App\Repositories\Amenity;

use App\Models\Amenity;
use App\Repositories\BaseRepository;

class AmenityRepository extends BaseRepository implements AmenityRepositoryInterface
{
    public function getModel()
    {
        return Amenity::class;
    }
}