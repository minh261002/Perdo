<?php

namespace App\Admin\Http\Controllers\Permission;

use App\Admin\DataTables\Permission\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\Permission\PermissionRequest;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Admin\Services\Permission\PermissionServiceInterface;

class PermissionController extends Controller
{
    protected $repository;
    protected $moduleRepository;

    protected $service;

    public function __construct(
        PermissionRepositoryInterface $repository,
        ModuleRepositoryInterface $moduleRepository,
        PermissionServiceInterface $service,
    ) {
        $this->repository = $repository;
        $this->moduleRepository = $moduleRepository;
        $this->service = $service;
    }

    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('admin.permission.index');
    }

    public function create()
    {
        $modules = $this->moduleRepository->getQueryBuilderOrderBy()->get();
        return view('admin.permission.create', compact('modules'));
    }

    public function store(PermissionRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.permission.index')->with('success', 'Thêm quyền mới thành công');
    }

    public function edit($id)
    {
        $permission = $this->repository->findOrFail($id);
        $modules = $this->moduleRepository->getQueryBuilderOrderBy()->get();
        return view('admin.permission.edit', compact('permission', 'modules'));
    }

    public function update(PermissionRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.permission.index')->with('success', 'Cập nhật quyền thành công');
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa quyền thành công']);
    }
}
