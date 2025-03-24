<?php

namespace App\Admin\Services\Brand;

use Illuminate\Http\Request;

interface BrandServiceInterface
{
    public function store(Request $request);
    public function update(Request $request);
}
