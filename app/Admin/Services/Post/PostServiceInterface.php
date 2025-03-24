<?php

namespace App\Admin\Services\Post;

use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function store(Request $request);

    public function update(Request $request);
}