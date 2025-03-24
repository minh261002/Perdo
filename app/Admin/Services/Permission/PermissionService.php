<?php

namespace App\Admin\Services\Permission;

use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionService implements PermissionServiceInterface
{
    protected $repository;

    public function __construct(PermissionRepositoryInterface $repository)
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