<?php

namespace App\Admin\Http\Controllers\Order;

use App\Admin\DataTables\Order\OrderDataTable;
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
}