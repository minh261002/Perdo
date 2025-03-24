<?php

namespace App\Admin\DataTables\Admin;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Admin\AdminRepositoryInterface;

class AdminDataTable extends BaseDataTable
{
    protected $nameTable = 'adminTable';
    protected $repository;

    public function __construct(
        AdminRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.admin.datatable.action',
            'image' => 'admin.admin.datatable.image',
            'status' => 'admin.admin.datatable.status',
        ];
    }

    public function query()
    {
        return $this->repository->getByQueryBuilder([], ['roles']);
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [1, 2, 3];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.admins', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'image' => $this->view['image'],
            'role' => function ($admin) {
                $roles = $admin->roles->pluck('name')->toArray();
                return '<code>' . implode(', ', $roles) . '</code>';
            },
            'status' => $this->view['status'],
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
            'image',
            'role',
            'status',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            'role' => function ($query, $keyword) {
                return $query->whereHas('roles', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            },
        ];
    }
}