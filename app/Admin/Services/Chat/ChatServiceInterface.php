<?php

namespace App\Admin\Services\Chat;

use Illuminate\Http\Request;

interface ChatServiceInterface
{
    public function send(Request $request);
}