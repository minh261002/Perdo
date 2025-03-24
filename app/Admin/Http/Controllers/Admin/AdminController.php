<?php

namespace App\Admin\Http\Controllers\Admin;

use App\Admin\DataTables\Admin\AdminDataTable;
use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\Admin\AdminRequest;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Admin\Services\Admin\AdminServiceInterface;

class AdminController extends Controller
{
    protected $repository;
    protected $roleRepository;
    protected $service;

    public function __construct(
        AdminRepositoryInterface $repository,
        RoleRepositoryInterface $roleRepository,
        AdminServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->service = $service;
    }

    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render('admin.admin.index');
    }

    public function create()
    {
        $roles = $this->roleRepository->getOrderBy('id', 'desc');
        return view('admin.admin.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $this->service->store($request);

        return redirect()->route('admin.admin.index')->with('success', 'Thêm quản trị viên thành công');
    }

    public function edit($id)
    {
        $admin = $this->repository->findOrFail($id);
        $roles = $this->roleRepository->getOrderBy('id', 'desc');
        return view('admin.admin.edit', compact('admin', 'roles'));
    }

    public function update(AdminRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.admin.index')->with('success', 'Cập nhật quản trị viên thành công');
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa quản trị viên thành công']);
    }
}
