<?php

namespace App\Admin\Http\Requests\Post;

use App\Admin\Http\Requests\BaseRequest;

class PostCatalogueRequest extends BaseRequest
{
    public function methodPost()
    {
        return [
            "name" => "required",
            "slug" => "nullable|unique:post_catalogues,slug",
            "parent_id" => "nullable|exists:post_catalogues,id",
            "desc" => "nullable",
            "status" => "required",
            'position' => 'required|integer',
            'image' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ];
    }

    public function methodPut()
    {
        return [
            "id" => "required|exists:post_catalogues,id",
            "name" => "required",
            "slug" => "nullable|unique:post_catalogues,slug," . $this->id,
            "parent_id" => "nullable|exists:post_catalogues,id|different:id",
            "desc" => "nullable",
            "status" => "required",
            'position' => 'required|integer',
            'image' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Tên chuyên mục không được để trống",
            "slug.unique" => "Slug đã tồn tại",
            "parent_id.exists" => "Chuyên mục cha không tồn tại",
            "status.required" => "Trạng thái không được để trống",
            "position.required" => "Vị trí không được để trống",
            "position.integer" => "Vị trí phải là số nguyên",
            "parent_id.different" => "Chuyên mục cha không được trùng với chính nó",
        ];
    }
}