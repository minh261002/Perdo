<?php

namespace App\Admin\DataTables\Post;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Post\PostRepositoryInterface;
use App\Enums\ActiveStatus;

class PostDataTable extends BaseDataTable
{
    protected $nameTable = 'postTable';
    protected $repository;

    public function __construct(
        PostRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.post.datatable.action',
            'image' => 'admin.post.datatable.image',
            'is_featured' => 'admin.post.datatable.feature',
            'status' => 'admin.post.datatable.status',
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3];
        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => ActiveStatus::asSelectArray()
            ],
            [
                'column' => 2,
                'data' => [
                    '0' => 'Không nổi bật',
                    '1' => 'Nổi bật'
                ]
            ]
        ];

    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.posts', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'image' => $this->view['image'],
            'is_featured' => $this->view['is_featured'],
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
            'is_featured',
            'status',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}