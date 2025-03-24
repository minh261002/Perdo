<?php

namespace App\Admin\Http\Requests\Admin;

use App\Admin\Http\Requests\BaseRequest;

class AdminRequest extends BaseRequest
{
    public function methodPost()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required',
            'address' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'phone' => 'nullable',
            'image' => 'nullable',
        ];
    }

    public function methodPut()
    {
        return [
            'id' => 'required|exists:admins,id',
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $this->id,
            'role_id' => 'required',
            'address' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'phone' => 'nullable',
            'image' => 'nullable',
            'password' => 'nullable|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu không khớp',
            'role_id.required' => 'Vui lòng chọn vai trò',
        ];
    }
}
