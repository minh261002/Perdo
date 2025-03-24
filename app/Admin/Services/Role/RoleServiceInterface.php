<?php

namespace App\Admin\Services\Role;

use Illuminate\Http\Request;

interface RoleServiceInterface
{
    public function store(Request $request);

    public function update(Request $request);
}