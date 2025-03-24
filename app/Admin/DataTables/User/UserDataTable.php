<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\ActiveStatus;
use App\Enums\User\UserLoginType;
use App\Enums\User\UserRole;
use App\Repositories\User\UserRepositoryInterface;

class UserDataTable extends BaseDataTable
{
    protected $nameTable = 'userTable';
    protected $repository;

    public function __construct(
        UserRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.user.datatable.action',
            'image' => 'admin.user.datatable.image',
            'status' => 'admin.user.datatable.status',
            'role' => 'admin.user.datatable.role',
            'login_type' => 'admin.user.datatable.login_type',
        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [1, 2, 3, 4, 5, 6];
        $this->columnSearchDate = [6];
        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => ActiveStatus::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => UserRole::asSelectArray()
            ],
            [
                'column' => 5,
                'data' => UserLoginType::asSelectArray()
            ]
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.users', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'image' => $this->view['image'],
            'status' => $this->view['status'],
            'created_at' => '{{format_datetime($created_at)}}',
            'login_type' => $this->view['login_type'],
            'role' => $this->view['role'],
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
            'login_type',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}