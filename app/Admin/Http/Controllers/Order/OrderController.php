<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\OrderDataTable;
use App\Enums\Order\OrderStatus;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController
{
    protected $repository;
    protected $statusRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
    ) {
        $this->repository = $orderRepository;
    }

    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    public function edit($id)
    {
        $order = $this->repository->findOrFail($id);
        $orderStatus = OrderStatus::asSelectArray();
        $paymentMethods = PaymentMethod::asSelectArray();
        $paymentStatus = PaymentStatus::asSelectArray();

        return view('admin.order.edit', compact('order', 'orderStatus', 'paymentMethods', 'paymentStatus'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'status',
            'id',
            'cancel_reason',
        ]);

        $order = $this->repository->findOrFail($data['id']);
        $order->update([
            'cancel_reason' => $data['cancel_reason'],
        ]);
        $order->statuses()->create([
            'order_id' => $order->id,
            'status' => $data['status'],
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }
}
