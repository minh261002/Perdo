@extends('client.layout.master')

@section('title', 'Thông tin cá nhân')

@section('content')
    <div class="my-30px">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('client.profile.components.left-side')

                    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('profile.change.password') }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <h2 class="mb-4">Đổi mật khẩu</h2>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>

                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" tabindex="1">
                                        <button class="btn border-primary" type="button" id="show_current_password">
                                            <i class="ti ti-eye fs-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <div></div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Mật khẩu mới</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password"
                                            tabindex="2">
                                        <button class="btn border-primary" type="button" id="show_password">
                                            <i class="ti ti-eye fs-2"></i>
                                        </button>
                                    </div>
                                </div>
                                <div></div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" tabindex="3">
                                        <button class="btn border-primary" type="button" id="show_password_confirmation">
                                            <i class="ti ti-eye fs-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <button type="submit" class="btn btn-primary btn-2"> Lưu thay đổi </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('form').submit(function() {
                $('.btn-2').attr('disabled', true);
                $('.btn-2').html(
                    `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Đang cập nhật...`
                );
            });

            $('#show_current_password').click(function() {
                let input = $('#current_password');
                let icon = $('#show_current_password i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye');
                    icon.addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off');
                    icon.addClass('ti-eye');
                }
            });

            $('#show_password').click(function() {
                let input = $('#password');
                let icon = $('#show_password i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye');
                    icon.addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off');
                    icon.addClass('ti-eye');
                }
            });

            $('#show_password_confirmation').click(function() {
                let input = $('#password_confirmation');
                let icon = $('#show_password_confirmation i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye');
                    icon.addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off');
                    icon.addClass('ti-eye');
                }
            });
        });
    </script>
@endpush
