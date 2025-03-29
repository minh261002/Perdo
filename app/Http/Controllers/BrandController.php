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
            'products' => function ($query) {
                $query->where('status', ActiveStatus::Active->value);
            },
            'categories'
        ])->first();

        $products = $brand->products()
            ->when(request('q'), fn($query, $q) => $query->where('name', 'like', "%{$q}%"))
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
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END DESC');
                        break;
                    case 'price_asc':
                        $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END ASC');
                        break;
                    default:
                        $query->latest();
                        break;
                }
            }, fn($query) => $query->latest())
            ->when(request('rating'), function ($query, $rating) {
                // Xử lý lọc theo rating nếu cần
            })
            ->paginate(12);

        return view('client.brand.index', [
            'brand' => $brand,
            'products' => $products,
        ]);
    }

}
