<?php

namespace App\Repositories\Transport;

use App\Repositories\BaseRepository;
use App\Models\Transport;

class TransportRepository extends BaseRepository implements TransportRepositoryInterface
{
    public function getModel()
    {
        return Transport::class;
    }
}
