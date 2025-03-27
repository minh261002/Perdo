<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable',
            'redirect' => 'nullable',
        ];
    }
}
