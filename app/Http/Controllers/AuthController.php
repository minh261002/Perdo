<?php

namespace App\Http\Controllers;

use App\Enums\ActiveStatus;
use App\Enums\User\UserLoginType;
use App\Http\Request\Auth\LoginRequest;
use App\Http\Request\Auth\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected $repository;

    public function __construct(
        UserRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function login()
    {
        return view('client.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $data = $request->validated();

        $remember = $data['remember'] ?? false;
        $redirect = $data['redirect'] ?? null;
        unset($data['redirect']);
        unset($data['remember']);

        $user = $this->repository->getByQueryBuilder(['email' => $data['email']])->first();
        if ($user->status->value == ActiveStatus::InActive->value) {
            return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa');
        }

        if (Auth::guard('web')->attempt($data, $remember)) {
            if ($redirect) {
                return
                    redirect()->to($redirect)->with('success', 'Xin chào, ' . Auth::guard('web')->user()->name);
            }
            return redirect()->route('home')->with('success', 'Xin chào, ' . Auth::guard('web')->user()->name);
        }

        return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác');
    }

    public function register()
    {
        return view('client.auth.register');
    }

    public function store(RegisterRequest $request)
    {

        $data = $request->validated();
        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        $user = $this->repository->create($data);

        if ($user) {
            Auth::guard('web')->login($user);
            return redirect()->route('home')->with('success', 'Xin chào ' . $user->name);
        }

        return redirect()->back()->with('error', 'Đã có lỗi xảy ra');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('home')->with('success', 'Đăng xuất thành công');
    }

    public function forgotPassword()
    {
        return view('client.auth.forgot-password');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $check = $this->repository->getByQueryBuilder(['email' => $user->email])->first();

        if (!empty($check) && $check->login_type == UserLoginType::Email->value || $check->login_type == UserLoginType::Google->value) {
            return redirect()->route('login')->with('error', 'Bạn đã đăng ký tài khoản này bằng email hoặc google!');
        }

        if (!empty($check) && $check->status == ActiveStatus::InActive) {
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa');
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->avatar,
            'login_type' => UserLoginType::Facebook->value
        ];
        $user = User::updateOrCreate(['email' => $user->email], $data);

        Auth::guard('web')->login($user);

        return redirect()->route('home')->with('success', 'Xin chào ' . $user->name);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $check = $this->repository->getByQueryBuilder(['email' => $user->email])->first();
        if (!empty($check) && $check->login_type == UserLoginType::Email || $check->login_type == UserLoginType::Facebook) {
            return redirect()->route('login')->with('error', 'Bạn đã đăng ký tài khoản này bằng email hoặc facebook!');
        }

        if (!empty($check) && $check->status == ActiveStatus::InActive) {
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa');
        }
        ;
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->avatar,
            'login_type' => UserLoginType::Google->value
        ];

        $user = User::updateOrCreate(['email' => $user->email], $data);

        Auth::guard('web')->login($user);
        return redirect()->route('home')->with('success', 'Xin chào ' . $user->name);
    }

}
