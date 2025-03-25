<?php

namespace App\Admin\Services\Slider;

use Illuminate\Http\Request;

interface SliderItemServiceInterface
{
    public function store(Request $request);
    public function update(Request $request);
    public function updateStatus(Request $request);
    public function delete(Request $request);
}