<?php

namespace App\Repositories\Slider;

use App\Repositories\BaseRepositoryInterface;

interface SliderItemRepositoryInterface extends BaseRepositoryInterface
{
    public function findOrFailWithRelations($id, $relations = ['slider']);
    public function getQueryBuilderByColumns($column, $value);
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
