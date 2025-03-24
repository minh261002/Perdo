<?php

namespace App\Admin\Http\Requests\Module;

use App\Admin\Http\Requests\BaseRequest;

class ModuleRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required|exists:modules,id',
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên module',
            'description.required' => 'Vui lòng nhập mô tả',
            'status.required' => 'Vui lòng chọn trạng thái',
            'id.required' => 'ID không được để trống',
            'id.exists' => 'ID không tồn tại',
        ];
    }
}