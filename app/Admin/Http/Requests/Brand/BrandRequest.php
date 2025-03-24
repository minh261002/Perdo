<?php

namespace App\Admin\Http\Requests\Brand;

use App\Admin\Http\Requests\BaseRequest;

class BrandRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
            'show_home' => 'nullable',
            'logo' => 'required',
            'banner' => 'nullable',
            'description' => 'nullable',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required|exists:brands,id',
            'name' => 'required',
            'category_id' => 'required',
            'show_home' => 'nullable',
            'logo' => 'required',
            'banner' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên thương hiệu không được để trống',
            'category_id.required' => 'Danh mục không được để trống',
            'show_home.required' => 'Hiển thị trên trang chủ không được để trống',
            'logo.required' => 'Logo không được để trống',
            'id.required' => 'Id không được để trống',
            'id.exists' => 'Id không tồn tại',
        ];
    }
}