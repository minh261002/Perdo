<?php

namespace App\Admin\Http\Requests\Product;

use App\Admin\Http\Requests\BaseRequest;


class ProductRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'product.name' => 'required',
            'product.sku' => 'required|unique:products,sku',
            'product.price' => 'required|min:0',
            'product.sale_price' => 'nullable|min:0|lt:product.price',
            'product.desc' => 'nullable',
            'product.meta_title' => 'nullable',
            'product.meta_desc' => 'nullable',
            'product.meta_keywords' => 'nullable',
            'product.status' => 'required',
            'product.image' => 'nullable',
            'product.stock' => 'required',
            'gallery' => 'nullable',
            'category_id' => 'required',
            'category_id.*' => 'required|exists:categories,id',
            'product.brand_id' => 'required|exists:brands,id',
        ];
    }

    protected function methodPut()
    {
        return [
            'product.id' => 'required|exists:products,id',
            'product.name' => 'required',
            'product.sku' => 'required|unique:products,sku,' . request()->product['id'],
            'product.price' => 'required|min:0',
            'product.sale_price' => 'nullable|min:0|lt:product.price',
            'product.desc' => 'nullable',
            'product.meta_title' => 'nullable',
            'product.meta_desc' => 'nullable',
            'product.meta_keywords' => 'nullable',
            'product.status' => 'required',
            'product.image' => 'nullable',
            'gallery' => 'nullable',
            'category_id' => 'required',
            'category_id.*' => 'required|exists:categories,id',
            'product.brand_id' => 'required|exists:brands,id',
            'product.stock' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product.name.required' => 'Tên sản phẩm không được để trống',
            'product.price.required' => 'Giá sản phẩm không được để trống',
            'product.price.min' => 'Giá sản phẩm phải lớn hơn 0',
            'product.sku.required' => 'Mã sản phẩm không được để trống',
            'product.sale_price.min' => 'Giá khuyến mãi phải lớn hơn 0',
            'product.sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá sản phẩm',
            'product.status.required' => 'Trạng thái không được để trống',
            'category_id.required' => 'Danh mục không được để trống',
            'category_id.*.required' => 'Danh mục không được để trống',
            'category_id.*.exists' => 'Danh mục không tồn tại',
            'product.brand_id.required' => 'Thương hiệu không được để trống',
            'product.brand_id.exists' => 'Thương hiệu không tồn tại',
            'product.stock.required' => 'Số lượng không được để trống',
        ];
    }
}