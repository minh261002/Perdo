<?php

namespace App\Admin\DataTables\Brand;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Enums\ActiveStatus;

class BrandDataTable extends BaseDataTable
{
    protected $nameTable = 'brandTable';
    protected $repository;

    public function __construct(
        BrandRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.brand.datatable.action',
            'logo' => 'admin.brand.datatable.logo',
            'status' => 'admin.brand.datatable.status',
            'show_home' => 'admin.brand.datatable.show_home',
        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3, 4];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => ActiveStatus::asSelectArray()
            ],
            [
                'column' => 3,
                'data' => [
                    '0' => 'Không hiển thị',
                    '1' => 'Hiển thị'
                ]
            ]
        ];
        $this->columnSearchDate = [4];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.brands', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'logo' => $this->view['logo'],
            'status' => $this->view['status'],
            'show_home' => $this->view['show_home'],
            'created_at' => '{{formatDate($created_at)}}'
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
            'logo',
            'status',
            'show_home',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}
