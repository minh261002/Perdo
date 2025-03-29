<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->repository = $productRepository;
    }

    public function show($slug)
    {
        $product = $this->repository->getBy(['slug' => $slug], ['categories', 'brand'])->first();

        $product_id = $product->id;
        $viewed_products = session()->get('viewed_products', []);
        if (!in_array($product_id, $viewed_products)) {
            array_unshift($viewed_products, $product_id);
            session()->put('viewed_products', $viewed_products);
            $product->update(['view_count' => $product->view_count + 1]);
        }

        $relatedProducts = $this->repository->getRelatedProducts($product);

        return view('client.product.show', compact('product', 'relatedProducts'));
    }

    public function search()
    {
        return view('client.product.search');
    }

    public function searchAjax(Request $request)
    {
        $query = $this->repository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value,
        ], [
            'categories',
            'brand'
        ]);
        $query = $query->when($request->has('q'), function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%");
        });

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }
}
