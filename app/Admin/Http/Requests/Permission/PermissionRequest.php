<?php

namespace App\Admin\Http\Requests\Permission;

use App\Admin\Http\Requests\BaseRequest;

class PermissionRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'title' => 'required',
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'required',
            'module_id' => 'required|exists:modules,id',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required|exists:permissions,id',
            'title' => 'required',
            'name' => 'required|unique:permissions,name,' . $this->id,
            'guard_name' => 'required',
            'module_id' => 'required|exists:modules,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên quyền',
            'name.unique' => 'Tên quyền đã tồn tại',
            'title.required' => 'Vui lòng nhập tiêu đề',
            'guard_name.required' => 'Vui lòng chọn guard name',
            'module_id.required' => 'Vui lòng chọn module',
            'module_id.exists' => 'Module không tồn tại',
            'id.required' => 'ID không được để trống',
            'id.exists' => 'ID không tồn tại',
        ];
    }
}
