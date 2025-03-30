<?php

namespace App\Admin\DataTables\Notification;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\ActiveStatus;
use App\Repositories\Notification\NotificationRepositoryInterface;

class NotificationDataTable extends BaseDataTable
{
    protected $nameTable = 'notificationTable';
    protected $repository;

    public function __construct(
        NotificationRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }

    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.notification.datatable.action',
            'read' => 'admin.notification.datatable.read',
        ];
    }

    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {
        $this->columnAllSearch = [0, 1, 2, 3, 4];
        $this->columnSearchDate = [4];
        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => [
                    '0' => 'Chưa đọc',
                    '1' => 'Đã đọc',
                ]
            ]
        ];
    }

    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.notifications', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'admin_id' => function ($row) {
                return $row->admin->name ?? 'N/A';
            },
            'user_id' => function ($row) {
                return $row->user->name ?? 'N/A';
            },
            'created_at' => '{{formatDate($created_at)}}',
            'is_read' => $this->view['read'],
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
            'is_read'
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}
