<?php

namespace App\Admin\DataTables\Module;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Module\ModuleRepositoryInterface;
use App\Enums\Module\ModuleStatus;

class ModuleDataTable extends BaseDataTable
{
    protected $nameTable = 'moduleTable';
    protected $repository;

    public function __construct(
        ModuleRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.module.datatable.action',
            'status' => 'admin.module.datatable.status',
            'description' => 'admin.module.datatable.description',
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2, 3];
        $this->columnSearchDate = [3];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => ModuleStatus::asSelectArray()
            ]
        ];

    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.modules', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'status' => $this->view['status'],
            'description' => $this->view['description'],
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
            'status',
            'description',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}