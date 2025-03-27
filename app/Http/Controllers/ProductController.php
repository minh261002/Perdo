<?php

namespace App\Http\Controllers;

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

        $related_products = $this->repository->getRelatedProducts($product);

        return view('client.product.show', compact('product'));
    }
}