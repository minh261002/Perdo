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
            'products' => function ($query) {
                $query->where('status', ActiveStatus::Active->value);
            },
            'brands' => function ($query) {
                $query->where('status', ActiveStatus::Active->value);
            },
        ])->first();

        $products = $category->products()
            ->when(request('q'), fn($query, $q) => $query->where('name', 'like', "%{$q}%"))
            ->when(request('brand_id'), fn($query, $brandId) => $query->where('brand_id', $brandId))
            ->when(request('min_price') && request('max_price'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereBetween('sale_price', [request('min_price'), request('max_price')])
                        ->orWhere(function ($q) {
                            $q->where('sale_price', 0)
                                ->whereBetween('price', [request('min_price'), request('max_price')]);
                        });
                });
            })
            ->when(request('min_price') && !request('max_price'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('sale_price', '>=', request('min_price'))
                        ->orWhere(function ($q) {
                            $q->where('sale_price', 0)
                                ->where('price', '>=', request('min_price'));
                        });
                });
            })
            ->when(request('max_price') && !request('min_price'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('sale_price', '<=', request('max_price'))
                        ->orWhere(function ($q) {
                            $q->where('sale_price', 0)
                                ->where('price', '<=', request('max_price'));
                        });
                });
            })
            ->when(request('sort'), function ($query, $sort) {
                switch ($sort) {
                    case 'price_asc':
                        $query->orderBy('sale_price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('sale_price', 'desc');
                        break;
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $brands = $category->brands;

        return view('client.category.index', [
            'category' => $category,
            'brands' => $brands,
            'products' => $products,
        ]);
    }

}
