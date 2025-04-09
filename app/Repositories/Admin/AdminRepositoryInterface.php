<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepositoryInterface;

interface AdminRepositoryInterface extends BaseRepositoryInterface
{
    public function search($keyword);
}