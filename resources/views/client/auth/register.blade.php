@extends('client.layout.master')

@section('title', 'Đăng ký tài khoản')

@section('content')
    <div class="d-flex align-items-center justify-content-center my-50px">
        <div class="container mx-auto" style="max-width: 550px;">
            <div class="card">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Đăng ký tài khoản</h2>
                    <form action="{{ route('store') }}" method="post" autocomplete="off" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="name" class="form-control" autocomplete="off" name="name"
                                value="{{ old('name') }}" tabindex="1">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" autocomplete="off" name="email"
                                value="{{ old('email') }}" tabindex="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Mật khẩu
                            </label>

                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" name="password" autocomplete="off"
                                    tabindex="2">

                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" title="Hiển thị mật khẩu"
                                        data-bs-toggle="tooltip" id="show_password">
                                        <i class="ti ti-eye fs-3"></i>
                                    </a>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Nhập lại mật khẩu
                            </label>

                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" name="password_confirmation" autocomplete="off"
                                    tabindex="2">

                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" title="Hiển thị mật khẩu"
                                        data-bs-toggle="tooltip" id="show_password_confirmation">
                                        <i class="ti ti-eye fs-3"></i>
                                    </a>
                                </span>
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Đăng ký tài khoản
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        Bạn đẫ có tài khoản ?
                        <a href="{{ route('login') }}" class="text-primary">
                            Đăng nhập ngay
                        </a>
                    </div>

                    @include('client.auth.social')
                </div>
            </div>
        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const showPasswordConfirmation = document.getElementById('show_password_confirmation');
            const passwordConfirmation = document.querySelector('input[name="password_confirmation"]');

            showPasswordConfirmation.addEventListener('click', function() {
                if (passwordConfirmation.type === 'password') {
                    passwordConfirmation.type = 'text';
                } else {
                    passwordConfirmation.type = 'password';
                }
            });
        });
    </script>
@endpush
