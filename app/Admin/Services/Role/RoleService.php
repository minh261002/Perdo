<?php

namespace App\Admin\Services\Role;

use App\Repositories\Role\RoleRepositoryInterface;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function store($request)
    {
        $data = $request->validated();

        $permissions = $data['permissions'];
        unset($data['permissions']);
        $role = $this->roleRepository->create($data);

        $role->permissions()->sync($permissions);

        return $role;
    }

    public function update($request)
    {
        $data = $request->validated();

        $permissions = $data['permissions'];
        unset($data['permissions']);
        $role = $this->roleRepository->update($data['id'], $data);

        $role->permissions()->sync($permissions);

        return $role;
    }
}