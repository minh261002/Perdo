<?php

namespace App\Services\Profile;

use Illuminate\Http\Request;

interface ProfileServiceInterface
{
    public function update(Request $request);

    public function updatePassword(Request $request);
}