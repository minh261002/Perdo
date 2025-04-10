<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Admin\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();
        $remember = $data['remember'] ?? false;
        $redirect = $data['redirect'] ?? null;
        unset($data['remember']);
        unset($data['redirect']);

        if (Auth::guard('admin')->attempt($data, $remember)) {
            if ($redirect) {
                return redirect()->to($redirect)->with('success', 'Xin chào, ' . Auth::guard('admin')->user()->name);
            }
            return redirect()->route('admin.dashboard')->with('success', 'Xin chào, ' . Auth::guard('admin')->user()->name);
        }

        return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công');
    }
}