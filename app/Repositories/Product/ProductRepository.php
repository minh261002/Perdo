<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function getRelatedProducts($product)
    {
        $id = $product->id;
        $category_ids = $product->categories->pluck('id')->toArray();

        return $this->model->where('id', '!=', $id)
            ->whereHas('categories', function ($query) use ($category_ids) {
                $query->whereIn('id', $category_ids);
            })
            ->with('categories', 'brand')
            ->limit(6)
            ->get();
    }
}
