<?php

namespace App\Admin\DataTables\Permission;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Permission\PermissionRepositoryInterface;

class PermissionDataTable extends BaseDataTable
{
    protected $nameTable = 'permissionTable';
    protected $repository;

    public function __construct(
        PermissionRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.permission.datatable.action',
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [0, 1, 2];

    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.permissions', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'name' => function ($permission) {
                return '<code>' . $permission->name . '</code>';
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
            'name',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}
