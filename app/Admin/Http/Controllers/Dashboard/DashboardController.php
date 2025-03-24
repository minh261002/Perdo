<?php

namespace App\Admin\Http\Controllers\Dashboard;

class DashboardController
{
    public function index()
    {
        return view('admin.dashboard.index');
    }
}