<?php

namespace App\Admin\Services\Brand;

use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Http\Request;

class BrandService implements BrandServiceInterface
{
    protected $repository;

    public function __construct(BrandRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $data = $request->validated();

        $category_ids = $data['category_id'];
        unset($data['category_id']);

        if (!empty($data['show_home'])) {
            $data['show_home'] = true;
        } else {
            $data['show_home'] = false;
        }

        $brand = $this->repository->create($data);
        $brand->categories()->attach($category_ids);

    }

    public function update(Request $request)
    {
        $data = $request->validated();

        $category_ids = $data['category_id'];
        unset($data['category_id']);

        if (!empty($data['show_home'])) {
            $data['show_home'] = true;
        } else {
            $data['show_home'] = false;
        }

        $brand = $this->repository->find($data['id']);
        $brand->categories()->sync($category_ids);

        $this->repository->update($data['id'], $data);
    }
}
