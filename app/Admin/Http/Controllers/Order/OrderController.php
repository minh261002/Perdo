<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\OrderDataTable;
use App\Enums\Order\OrderStatus;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderController
{
    protected $repository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
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
        $paymentMethod = PaymentMethod::asSelectArray();
        $paymentStatus = PaymentStatus::asSelectArray();

        return view('admin.order.edit', compact('order', 'orderStatus', 'paymentMethod', 'paymentStatus'));
    }
}