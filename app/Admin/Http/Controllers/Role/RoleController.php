<?php

namespace App\Admin\Http\Controllers\Role;

use App\Admin\DataTables\Role\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\Role\RoleRequest;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Admin\Services\Role\RoleServiceInterface;

class RoleController extends Controller
{
    protected $repository;
    protected $moduleRepository;
    protected $service;

    public function __construct(
        RoleRepositoryInterface $repository,
        RoleServiceInterface $service,
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('admin.role.index');
    }

    public function create()
    {
        $modules = $this->repository->getAllPermissionsInAllModules();
        return view('admin.role.create', compact('modules'));
    }

    public function store(RoleRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.role.index')->with('success', 'Thêm quyền mới thành công');
    }

    public function edit(int $id)
    {
        $role = $this->repository->find($id);
        $modules = $this->repository->getAllPermissionsInAllModules();
        return view('admin.role.edit', compact('role', 'modules'));
    }

    public function update(RoleRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.role.index')->with('success', 'Cập nhật quyền thành công');
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa quyền thành công']);
    }
}