<?php

namespace App\Http\Controllers;

use App\Http\Request\Profile\UpdateProfileRequest;
use App\Services\Profile\ProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $service;

    public function __construct(
        ProfileServiceInterface $service
    ) {
        $this->service = $service;
    }

    public function index()
    {
        $user = Auth::guard('web')->user();
        return view('client.profile.index', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->service->update($request);
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
    }
}