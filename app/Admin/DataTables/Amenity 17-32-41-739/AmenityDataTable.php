<?php

namespace App\Admin\DataTables\Amenity;

use App\Admin\DataTables\BaseDataTable;
use App\Enums\Amenity\AmenityGroup;
use App\Repositories\Amenity\AmenityRepositoryInterface;

class AmenityDataTable extends BaseDataTable
{
    protected $nameTable = 'amenityTable';
    protected $repository;

    public function __construct(
        AmenityRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.amenity.datatable.action',
            'group' => 'admin.amenity.datatable.group',
            'image' => 'admin.amenity.datatable.image',
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2];
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => AmenityGroup::asSelectArray(),
            ]
        ];

    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.amenities', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'icon' => $this->view['image'],
            'group' => $this->view['group'],
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
            'group',
            'icon',
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}
