<?php

namespace App\Admin\Http\Controllers\Discount;

use App\Admin\DataTables\Discount\DiscountDataTable;
use App\Admin\Http\Requests\Discount\DiscountRequest;
use App\Admin\Services\Discount\DiscountServiceInterface;
use App\Enums\ActiveStatus;
use App\Enums\Discount\DiscountApplyFor;
use App\Enums\Discount\DiscountType;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class DiscountController
{
    protected $repository;
    protected $service;
    protected $customerRepository;

    public function __construct(
        DiscountRepositoryInterface $repository,
        UserRepositoryInterface $customerRepository,
        DiscountServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->customerRepository = $customerRepository;
    }

    public function index(DiscountDataTable $dataTable)
    {
        return $dataTable->render('admin.discount.index');
    }

    public function create()
    {
        $status = ActiveStatus::asSelectArray();
        $types = DiscountType::asSelectArray();
        $applyFor = DiscountApplyFor::asSelectArray();

        $member = $this->customerRepository->getByQueryBuilder(
            ['status' => ActiveStatus::Active->value],
        )->get();

        return view('admin.discount.create', compact('status', 'types', 'applyFor', 'member'));
    }

    public function store(DiscountRequest $request)
    {
        $this->service->store($request);
        return redirect()->route('admin.discount.index')->with('success', 'Thêm mã giảm giá mới thành công');
    }

    public function edit($id)
    {
        $discount = $this->repository->find($id);
        $status = ActiveStatus::asSelectArray();
        $types = DiscountType::asSelectArray();
        $applyFor = DiscountApplyFor::asSelectArray();
        $member = $this->customerRepository->getByQueryBuilder(
            ['status' => ActiveStatus::Active->value],
        )->get();
        return view('admin.discount.edit', compact('discount', 'status', 'types', 'applyFor', 'member'));
    }

    public function update(DiscountRequest $request)
    {
        $this->service->update($request);
        return redirect()->route('discount.index')->with('success', 'Cập nhật mã giảm giá thành công');
    }

    public function updateStatus(Request $request)
    {
        $data = $request->only('id', 'status');
        $this->repository->update($data['id'], $data);
        return response()->json(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công']);
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa mã giảm giá thành công']);
    }

}