<?php

namespace App\Admin\Http\Controllers\User;

use App\Admin\DataTables\User\UserDataTable;
use App\Enums\ActiveStatus;
use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\User\UserRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(
        UserRepositoryInterface $repository,
        UserServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.user.index');
    }

    public function create()
    {
        $status = ActiveStatus::asSelectArray();
        return view('admin.user.create', compact('status'));
    }

    public function store(UserRequest $request)
    {
        $this->service->store($request);

        return redirect()->route('admin.user.index')->with('success', 'Thêm khách hàng thành công');
    }

    public function edit($id)
    {
        $user = $this->repository->findOrFail($id);
        $status = ActiveStatus::asSelectArray();
        return view('admin.user.edit', compact('user', 'status'));
    }

    public function update(UserRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.user.index')->with('success', 'Cập nhật khách hàng thành công');
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only(['id', 'status']);
        $this->repository->update($data['id'], $data);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công']);
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa khách hàng thành công']);
    }
}
