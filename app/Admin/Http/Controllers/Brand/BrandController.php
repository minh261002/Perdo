<?php

namespace App\Admin\Http\Controllers\Brand;

use App\Admin\DataTables\Brand\BrandDataTable;
use App\Enums\ActiveStatus;
use App\Admin\Http\Requests\Brand\BrandRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Admin\Services\Brand\BrandServiceInterface;
use Illuminate\Http\Request;

class BrandController
{
    protected $repository;

    protected $service;

    public function __construct(
        BrandRepositoryInterface $repository,
        BrandServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(BrandRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.brand.index')->with('success', 'Thêm thương hiệu mới thành công');
    }

    public function edit($id)
    {
        $status = ActiveStatus::asSelectArray();
        $brand = $this->repository->find($id);
        return view('admin.brand.edit', compact('brand', 'status'));
    }

    public function update(BrandRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('admin.brand.index')->with('success', 'Cập nhật thương hiệu thành công');
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only('id', 'status');
        $this->repository->update($data['id'], $data);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công']);
    }

    public function delete(Request $request)
    {
        $this->repository->delete($request->id);
        return response()->json(['message' => 'Xóa thương hiệu thành công']);
    }
}
