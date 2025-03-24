<?php

namespace App\Admin\Http\Requests\Role;

use App\Admin\Http\Requests\BaseRequest;

class RoleRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'title' => 'required',
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required',
            'permissions' => 'required',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required|exists:roles,id',
            'title' => 'required',
            'name' => 'required|unique:roles,name,' . $this->id,
            'guard_name' => 'required',
            'permissions' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'name.required' => 'Vui lòng nhập tên',
            'name.unique' => 'Tên đã tồn tại',
            'guard_name.required' => 'Vui lòng nhập guard name',
            'permissions.required' => 'Vui lòng chọn quyền',
        ];
    }
}
