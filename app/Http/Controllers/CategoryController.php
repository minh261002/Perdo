<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(
        CategoryRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function index($slug)
    {
        $category = $this->repository->getByQueryBuilder([
            'slug' => $slug,
        ], [
            'products',
            'brands',
        ])->first();

        $products = $category->products()->where('status', ActiveStatus::Active->value);

        $brands = $category->brands()->where('status', ActiveStatus::Active->value)->get();

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

        if (request()->has('brand_id')) {
            $products->whereHas('brand', function ($query) {
                $query->where('brand_id', request()->get('brand_id'));
            });
        }

        if (request()->has('sort')) {
            switch (request()->get('sort')) {
                case 'price_asc':
                    $products->orderBy('sale_price', 'asc');
                    break;
                case 'price_desc':
                    $products->orderBy('sale_price', 'desc');
                    break;
                case 'name_asc':
                    $products->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $products->orderBy('name', 'desc');
                    break;
                default:
                    break;
            }
        }

        $products = $products->paginate(12);

        return view('client.category.index', [
            'category' => $category,
            'brands' => $brands,
            'products' => $products,
        ]);
    }
}