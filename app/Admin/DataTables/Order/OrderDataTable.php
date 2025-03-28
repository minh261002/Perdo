<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\Order\OrderStatus;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderDataTable extends BaseDataTable
{
    protected $nameTable = 'orderTable';
    protected $repository;

    public function __construct(
        OrderRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.order.datatable.action',
            'status' => 'admin.order.datatable.status',
        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];
        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => OrderStatus::asSelectArray()
            ],
        ];
        $this->columnSearchDate = [5];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.orders', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'created_at' => '{{formatDate($created_at)}}',
            'total' => '{{format_price($total)}}',
            'status' => function ($query) {
                return view($this->view['status'], ['query' => $query]);
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
            'status',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'status' => function ($query, $keyword) {
                return $query->whereHas('statuses', function ($query) use ($keyword) {
                    $query->where('status', $keyword)
                        ->whereIn('id', function ($subQuery) {
                            $subQuery->selectRaw('MAX(id)')
                                ->from('order_statuses')
                                ->whereColumn('order_id', 'orders.id');
                        });
                });
            }
        ];
    }
}
