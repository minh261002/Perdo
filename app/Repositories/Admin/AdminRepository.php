<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Models\Admin;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    public function getModel()
    {
        return Admin::class;
    }
}
