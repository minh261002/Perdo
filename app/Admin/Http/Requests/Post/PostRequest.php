<?php

namespace App\Admin\Http\Requests\Post;

use App\Admin\Http\Requests\BaseRequest;

class PostRequest extends BaseRequest
{

    public function methodPost()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'catalogue_id' => 'required',
            'status' => 'required',
            'is_feature' => 'required',
            'image' => 'nullable',
        ];
    }

    public function methodPut()
    {
        return [
            'id' => 'required|exists:posts,id',
            'title' => 'required',
            'content' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'catalogue_id' => 'required',
            'status' => 'required',
            'is_feature' => 'required',
            'image' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề không được để trống',
            'content.required' => 'Nội dung không được để trống',
            'catalogue_id.required' => 'Danh mục không được để trống',
            'status.required' => 'Trạng thái không được để trống',
            'is_featured.required' => 'Nổi bật không được để trống',
            'id.required' => 'ID không được để trống',
            'id.exists' => 'ID không tồn tại',
        ];
    }
}