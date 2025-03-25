<?php

namespace App\Admin\DataTables\Slider;

use App\Admin\DataTables\BaseDataTable;
use App\Repositories\Slider\SliderItemRepositoryInterface;
use App\Enums\ActiveStatus;

class SliderItemDataTable extends BaseDataTable
{
    protected $nameTable = 'sliderItemTable';
    protected $repository;

    public function __construct(
        SliderItemRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(): void
    {
        $this->view = [
            'action' => 'admin.slider.item.datatable.action',
            'image' => 'admin.slider.item.datatable.image',
        ];
    }
    public function query()
    {
        $sliderId = request()->route('id');
        return $this->repository->getByQueryBuilder([
            'slider_id' => $sliderId
        ]);
    }

    public function setColumnSearch(): void
    {

        $this->columnAllSearch = [1, 2, 3];

        $this->columnSearchSelect = [

        ];
    }
    protected function setCustomColumns(): void
    {
        $this->customColumns = config('datatable_columns.slider_items', []);
    }

    protected function setCustomEditColumns(): void
    {
        $this->customEditColumns = [
            'action' => $this->view['action'],
            'image' => $this->view['image'],
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
        ];
    }

    public function setCustomFilterColumns(): void
    {
        $this->customFilterColumns = [
            //
        ];
    }
}