<?php

namespace App\Http\Controllers;

use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $repository;

    public function __construct(
        BrandRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function index($slug)
    {
        $brand = $this->repository->getByQueryBuilder([
            'slug' => $slug,
        ], [
            'products',
            'categories',
        ])->first();

        return view('client.brand.index', [
            'brand' => $brand,
        ]);
    }
}
