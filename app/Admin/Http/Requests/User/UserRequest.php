<?php

namespace App\Admin\Http\Requests\User;

use App\Admin\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{
    public function methodPost()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'address' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'phone' => 'nullable',
            'birthday' => 'nullable',
            'image' => 'nullable',
            'description' => 'nullable',
            'status' => 'required',
        ];
    }

    public function methodPut()
    {
        return [
            'id' => 'required|exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'address' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'phone' => 'nullable|unique:users,phone,' . $this->id,
            'birthday' => 'nullable',
            'image' => 'nullable',
            'description' => 'nullable',
            'password' => 'nullable|min:6|confirmed',
            'status' => 'required',
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
            'status.required' => 'Trạng thái không được để trống',
        ];
    }
}
