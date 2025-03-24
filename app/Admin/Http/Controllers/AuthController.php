<?php

namespace App\Admin\Http\Controllers;

class AuthController
{
    public function login()
    {
        return view('admin.auth.login');
    }
}
