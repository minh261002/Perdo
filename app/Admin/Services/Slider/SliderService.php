<?php

namespace App\Admin\Services\Slider;

use App\Repositories\Slider\SliderRepositoryInterface;
use Illuminate\Http\Request;

class SliderService implements SliderServiceInterface
{
    protected $sliderRepository;

    public function __construct(SliderRepositoryInterface $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        // dd($data);
        return $this->sliderRepository->create($data);
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        $sliderId = $data['id'];

        return $this->sliderRepository->update($sliderId, $data);
    }

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $id = $data['slider_id'];
        $status = $data['status'];

        return $this->sliderRepository->update($id, ['status' => $status]);
    }

    public function delete($id)
    {
        return $this->sliderRepository->delete($id);
    }
}