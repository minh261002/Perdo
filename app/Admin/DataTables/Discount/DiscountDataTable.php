<?php

namespace App\Admin\DataTables\Discount;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\Discount\DiscountType;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Enums\ActiveStatus;

class DiscountDataTable extends BaseDataTable
{
    protected $nameTable = 'discountTable';
    protected $repository;

    public function __construct(
        DiscountRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.discount.datatable.action',
            'status' => 'admin.discount.datatable.status',
            'type' => 'admin.discount.datatable.type',
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
                'column' => 5,
                'data' => ActiveStatus::asSelectArray()
            ],
            [
                'column' => 3,
                'data' => DiscountType::asSelectArray()
            ]
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.discounts', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'status' => $this->view['status'],
            'date_start' => function ($query) {
                return formatDate($query->date_start);
            },
            'date_end' => function ($query) {
                return formatDate($query->date_end);
            },
            'type' => $this->view['type'],
        ];
    }

    protected function setCustomAddColumns(): void
    {
        $this->customAddColumns = [
            'action' => $this->view['action'],
            'value' => function ($query) {
                if ($query->type == DiscountType::Percentage) {
                    return $query->percent_value . '%';
                } else {
                    return format_price($query->discount_value);
                }
            }
        ];
    }

    protected function setCustomRawColumns(): void
    {
        $this->customRawColumns = [
            'action',
            'type',
            'status',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'value' => function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('discount_value', 'like', '%' . $keyword . '%')
                        ->orWhere('percent_value', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}
