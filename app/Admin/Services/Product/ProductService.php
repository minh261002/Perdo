<?php

namespace App\Admin\Services\Product;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService implements ProductServiceInterface
{
    protected $repository;

    public function __construct(
        ProductRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        if (!empty($data['product']['image'])) {
            $data['product']['image'] = $data['product']['image'] ?? 'images/not-found.jpg';
        }
        if (!empty($data['gallery'])) {
            $data['gallery'] = json_encode($data['gallery']);
        } else {
            $data['gallery'] = json_encode([]);
        }
        $data['product']['gallery'] = $data['gallery'];
        $product = $this->repository->create($data['product']);

        $product->categories()->attach($data['category_id']);

        return $product;
    }

    public function update(Request $request)
    {
        $data = $request->validated();

        if (!empty($data['product']['image'])) {
            $data['product']['image'] = $data['product']['image'] ?? 'images/not-found.jpg';
        }
        if (!empty($data['gallery'])) {
            $data['gallery'] = json_encode($data['gallery']);
        } else {
            $data['gallery'] = json_encode([]);
        }
        $data['product']['gallery'] = $data['gallery'];
        $product = $this->repository->update($data['product']['id'], $data['product']);

        $product->categories()->sync($data['category_id']);

        return $product;
    }
}