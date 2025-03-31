<?php

namespace App\Admin\DataTables\Transport;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\Transport\TransportMethod;
use App\Enums\Transport\TransportStatus;
use App\Repositories\Transport\TransportRepositoryInterface;
use App\Enums\Order\OrderStatus;

class TransportDataTable extends BaseDataTable
{
    protected $nameTable = 'transportTable';
    protected $repository;

    public function __construct(
        TransportRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.transport.datatable.action',
            'status' => 'admin.transport.datatable.status',
            'method' => 'admin.transport.datatable.method',
            'order' => 'admin.transport.datatable.order',
            'user' => 'admin.transport.datatable.user',
            'code' => 'admin.transport.datatable.code',
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];
        $this->columnSearchDate = [5];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => TransportMethod::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => TransportStatus::asSelectArray()
            ]
        ];

    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.transports', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'created_at' => '{{formatDate($created_at)}}',
            'status' => function ($model) {
                return view($this->view['status'], compact('model'));
            },
            'method' => $this->view['method'],
            'order_id' => function ($model) {
                return view($this->view['order'], compact('model'));
            },
            'user' => function ($model) {
                return view($this->view['user'], compact('model'));
            },
            'transport_code' => function ($model) {
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
            'status',
            'method',
            'order_id',
            'user',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'order_id' => function ($query, $keyword) {
                return $query->whereHas('order', function ($query) use ($keyword) {
                    $query->where('order_code', $keyword);
                });
            },
            'user' => function ($query, $keyword) {
                return $query->whereHas('order', function ($query) use ($keyword) {
                    $query->where('user_id', $keyword);
                })->orWhereHas('order', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            },
            'status' => function ($query, $keyword) {
                return $query->whereHas('statuses', function ($query) use ($keyword) {
                    $query->where('status', $keyword)
                        ->where('created_at', function ($query) {
                            $query->selectRaw('MAX(created_at)')
                                ->from('transport_statuses')
                                ->whereColumn('transport_id', 'transports.id');
                        });
                });
            },
        ];
    }
}
