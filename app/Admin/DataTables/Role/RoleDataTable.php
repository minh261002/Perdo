<?php

namespace App\Admin\DataTables\Role;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Role\RoleRepositoryInterface;

class RoleDataTable extends BaseDataTable
{
    protected $nameTable = 'roleTable';
    protected $repository;

    public function __construct(
        RoleRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.role.datatable.action',
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
        $this->customColumns = config('datatable_columns.roles', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'name' => function ($role) {
                return '<code>' . $role->name . '</code>';
            }
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