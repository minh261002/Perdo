<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Repositories\Slider\SliderRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $sliderRepository;

    public function __construct(SliderRepositoryInterface $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    public function index()
    {
        $homeSlider = $this->sliderRepository->getByQueryBuilder([
            'key' => 'home_slider',
            'status' => ActiveStatus::Active->value
        ], ['items'])->first();

        return view('client.home.index', compact('homeSlider'));
    }
}
