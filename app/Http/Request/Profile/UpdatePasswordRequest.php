<?php

namespace App\Http\Request\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Mật khẩu hiện tại không được để trống',
            'password.required' => 'Mật khẩu mới không được để trống',
            'password.confirmed' => 'Mật khẩu mới không trùng khớp',
            'password.min' => 'Mật khẩu mới phải chứa ít nhất 6 ký tự',
            'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống'
        ];
    }
}