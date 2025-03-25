<?php

namespace App\Repositories\Slider;

use App\Repositories\BaseRepositoryInterface;

interface SliderRepositoryInterface extends BaseRepositoryInterface
{
    public function getQueryBuilderWithRelations(array $relations = ['items']);

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
