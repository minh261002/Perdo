<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\Slider\SliderRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $sliderRepository;
    protected $brandRepository;
    protected $discountRepository;

    public function __construct(
        SliderRepositoryInterface $sliderRepository,
        BrandRepositoryInterface $brandRepository,
        DiscountRepositoryInterface $discountRepository
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->brandRepository = $brandRepository;
        $this->discountRepository = $discountRepository;
    }

    public function index()
    {
        $homeSlider = $this->sliderRepository->getByQueryBuilder([
            'key' => 'home_slider',
            'status' => ActiveStatus::Active->value
        ], ['items'])->first();
        $homeBrand = $this->brandRepository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value,
            'show_home' => true
        ])->get();
        $homeDiscounts = $this->discountRepository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value,
            'show_home' => true
        ])->get();

        return view('client.home.index', compact('homeSlider', 'homeBrand', 'homeDiscounts'));
    }
}