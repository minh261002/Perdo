<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
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

        $products = $brand->products()->where('status', ActiveStatus::Active->value);

        if (request()->has('q')) {
            $products->where('name', 'like', '%' . request()->get('q') . '%');
        }

        if (request()->has('min_price') && request()->has('max_price')) {
            $products->where(function ($query) {
                $query->whereBetween('sale_price', [request()->get('min_price'), request()->get('max_price')])
                    ->orWhere(function ($query) {
                        $query->where('sale_price', 0)
                            ->whereBetween('price', [request()->get('min_price'), request()->get('max_price')]);
                    });
            });
        } elseif (request()->has('min_price')) {
            $products->where(function ($query) {
                $query->where('sale_price', '>=', request()->get('min_price'))
                    ->orWhere(function ($query) {
                        $query->where('sale_price', 0)
                            ->where('price', '>=', request()->get('min_price'));
                    });
            });
        } elseif (request()->has('max_price')) {
            $products->where(function ($query) {
                $query->where('sale_price', '<=', request()->get('max_price'))
                    ->orWhere(function ($query) {
                        $query->where('sale_price', 0)
                            ->where('price', '<=', request()->get('max_price'));
                    });
            });
        }

        if (request()->has('sort')) {
            $sort = request()->get('sort');
            switch ($sort) {
                case 'name_desc':
                    $products->orderBy('name', 'desc');
                    break;
                case 'name_asc':
                    $products->orderBy('name', 'asc');
                    break;
                case 'price_desc':
                    $products->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END DESC');
                    break;
                case 'price_asc':
                    $products->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END ASC');
                    break;
                default:
                    $products->latest();
            }
        } else {
            $products->latest();
        }

        if (request()->has('rating')) {
            //
        }

        $products = $products->paginate(12);

        return view('client.brand.index', [
            'brand' => $brand,
            'products' => $products,
        ]);
    }
}