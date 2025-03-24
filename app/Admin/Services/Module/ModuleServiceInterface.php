<?php

namespace App\Admin\Services\Module;

use Illuminate\Http\Request;

interface ModuleServiceInterface
{
    public function store(Request $request);
    public function update(Request $request);
}
