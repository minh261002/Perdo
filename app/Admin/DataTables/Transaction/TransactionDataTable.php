<?php

namespace App\Admin\DataTables\Transaction;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Enums\Order\OrderStatus;

class TransactionDataTable extends BaseDataTable
{
    protected $nameTable = 'transactionTable';
    protected $repository;

    public function __construct(
        TransactionRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.transaction.datatable.action',
            'status' => 'admin.transaction.datatable.status',
            'method' => 'admin.transaction.datatable.method',
            'order' => 'admin.transaction.datatable.order',
            'user' => 'admin.transaction.datatable.user',
            'code' => 'admin.transaction.datatable.code',
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5, 6];
        $this->columnSearchDate = [6];
        $this->columnSearchSelect = [
            [
                'column' => 5,
                'data' => PaymentStatus::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => PaymentMethod::asSelectArray()
            ]
        ];

    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.transactions', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'created_at' => '{{formatDate($created_at)}}',
            'amount' => '{{format_price($amount)}}',
            'payment_status' => $this->view['status'],
            'payment_method' => $this->view['method'],
            'order_id' => function ($model) {
                return view($this->view['order'], compact('model'));
            },
            'user_id' => function ($model) {
                return view($this->view['user'], compact('model'));
            },
            'transaction_code' => function ($model) {
                return view($this->view['code'], compact('model'));
            },
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'action',
            'payment_status',
            'payment_method',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'user_id' => function ($query, $keyword) {
                return $query->whereHas('order', function ($query) use ($keyword) {
                    $query->where('user_id', $keyword);
                })->orWhereHas('order', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}