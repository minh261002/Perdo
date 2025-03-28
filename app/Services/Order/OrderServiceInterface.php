<?php

namespace App\Services\Order;

use Illuminate\Http\Request;

interface OrderServiceInterface
{
    public function store(Request $request);

    public function vnpayCallback(Request $request);

    public function momoCallback(Request $request);

    public function payosCallback(Request $request);
}