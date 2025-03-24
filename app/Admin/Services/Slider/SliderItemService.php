<?php

namespace App\Admin\Services\Slider;

use App\Repositories\Slider\SliderItemRepositoryInterface;

use Illuminate\Http\Request;

class SliderItemService implements SliderItemServiceInterface
{
    protected $sliderItemRepository;

    public function __construct(SliderItemRepositoryInterface $sliderItemRepository)
    {
        $this->sliderItemRepository = $sliderItemRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        return $this->sliderItemRepository->create($data);
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        $sliderId = $data['id'];

        return $this->sliderItemRepository->update($sliderId, $data);
    }

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $id = $data['slider_id'];
        $status = $data['status'];

        return $this->sliderItemRepository->update($id, ['status' => $status]);
    }

    public function delete($id)
    {
        return $this->sliderItemRepository->delete($id);
    }
}
