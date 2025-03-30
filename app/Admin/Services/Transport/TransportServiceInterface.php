<?php

namespace App\Admin\Services\Transport;

use Illuminate\Http\Request;

interface TransportServiceInterface
{
    public function store(Request $request);
}
