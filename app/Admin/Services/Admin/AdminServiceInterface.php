<?php

namespace App\Admin\Services\Admin;

use Illuminate\Http\Request;

interface AdminServiceInterface
{
    public function store(Request $request);

    public function update(Request $request);
}