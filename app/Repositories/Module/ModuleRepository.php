<?php

namespace App\Repositories\Module;

use App\Models\Module;
use App\Repositories\BaseRepository;

class ModuleRepository extends BaseRepository implements ModuleRepositoryInterface
{
    public function getModel()
    {
        return Module::class;
    }
}