<?php

namespace App\Admin\Services\Discount;

use Illuminate\Http\Request;

interface DiscountServiceInterface
{
    public function store(Request $request);

    public function update(Request $request);
}
