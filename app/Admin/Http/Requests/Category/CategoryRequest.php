<?php

namespace App\Admin\Http\Requests\Category;

use App\Admin\Http\Requests\BaseRequest;

class CategoryRequest extends BaseRequest
{
    public function methodPost()
    {
        return [
            "name" => "required",
            "slug" => "nullable|unique:categories,slug",
            "parent_id" => "nullable|exists:categories,id",
            "desc" => "nullable",
            "status" => "required",
            'position' => 'required|integer',
            'image' => 'nullable',
            'show_menu' => 'nullable',
            'show_home' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ];
    }

    public function methodPut()
    {
        return [
            "id" => "required|exists:categories,id",
            "name" => "required",
            "slug" => "nullable|unique:categories,slug," . $this->id,
            "parent_id" => "nullable|exists:categories,id|different:id",
            "desc" => "nullable",
            "status" => "required",
            'position' => 'required|integer',
            'image' => 'nullable',
            'show_menu' => 'nullable',
            'show_home' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Tên danh mục không được để trống",
            "slug.unique" => "Slug đã tồn tại",
            "parent_id.exists" => "Danh mục cha không tồn tại",
            "status.required" => "Trạng thái không được để trống",
            "position.required" => "Vị trí không được để trống",
            "position.integer" => "Vị trí phải là số nguyên",
            "parent_id.different" => "Danh mục cha không được trùng với chính nó",
        ];
    }
}
