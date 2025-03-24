<?php

namespace App\Admin\Services\Module;

use App\Repositories\Module\ModuleRepositoryInterface;
use Illuminate\Http\Request;

class ModuleService implements ModuleServiceInterface
{
    protected $repository;

    public function __construct(ModuleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        return $this->repository->create($data);
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        return $this->repository->update($data['id'], $data);
    }
}