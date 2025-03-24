@extends('admin.layouts.guard_layout')

@section('guard_title')
    {{ __('Đăng nhập') }}
@endsection


@section('guard_content')
    <div class="card-body">
        <h2 class="h2 text-center mb-4">{{ __('Quản trị viên') }}</h2>
        <form action="{{ route('admin.authenticate') }}" method="post" autocomplete="off" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input type="email" class="form-control" autocomplete="off" name="email" value="{{ old('email') }}"
                    tabindex="1">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    {{ __('Mật khẩu') }}
                    <span class="form-label-description">
                        <a href="{{ route('admin.password.forgot') }}">
                            {{ __('Quên mật khẩu?') }}
                        </a>
                    </span>
                </label>
                <div class="input-group input-group-flat">
                    <input type="password" class="form-control" name="password" autocomplete="off" tabindex="2">

                    <span class="input-group-text">
                        <a href="#" class="link-secondary" title="Hiển thị mật khẩu" data-bs-toggle="tooltip"
                            id="show_password">
                            <i class="ti ti-eye fs-3"></i>
                        </a>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" tabindex="3">
                    <span class="form-check-label">
                        {{ __('Ghi nhớ đăng nhập') }}
                    </span>
                </label>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Đăng nhập') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                const button = form.querySelector('button[type="submit"]');
                button.innerHTML =
                    '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
                button.disabled = true;
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const showPassword = document.getElementById('show_password');
            const password = document.querySelector('input[name="password"]');

            showPassword.addEventListener('click', function() {
                if (password.type === 'password') {
                    password.type = 'text';
                } else {
                    password.type = 'password';
                }
            });
        });
    </script>
@endpush
