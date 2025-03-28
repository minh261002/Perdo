@extends('client.layout.master')

@section('title', 'Thông tin cá nhân')

@section('content')
    <div class="my-30px">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('client.profile.components.left-side')

                    <form class="col-12 col-md-9 d-flex flex-column" action="{{ route('profile.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <h2 class="mb-4">Thông tin cá nhân</h2>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url('{{ $user->image }}')"></span>
                                    <input type="file" name="image"
                                        value="{{ $user->image ?? 'images/not-found.jpg' }}" id="image" hidden>
                                </div>
                                <div class="col-auto">
                                    <label for="image" class="btn btn-1"> Chọn ảnh </label>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-ghost-danger btn-3"> Xoá ảnh </a>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name) }}" placeholder="Nhập họ và tên">
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" placeholder="Nhập email">
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="phone" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="birthday" class="form-label">
                                        Ngày sinh
                                    </label>

                                    <div class="input-icon mb-2">
                                        <input class="form-control " placeholder="Chọn ngày" id="datepicker-icon"
                                            value="{{ old('birthday', $user->birthday) }}" name="birthday"
                                            autocomplete="off">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar fs-1"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 form-group">
                                    @include('components.pick-address', [
                                        'label' => 'Địa chỉ cụ thể',
                                        'name' => 'address',
                                        'value' => old('address', $user->address ?? ''),
                                    ])
                                    <input type="hidden" name="lat" value="{{ old('lat', $user->lat ?? '') }}">
                                    <input type="hidden" name="lng" value="{{ old('lng', $user->lng ?? '') }}">
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

    @include('components.modal-pick-address')
    @include('components.google-map-script')
@endsection


@push('scripts')
    <script src="{{ asset('libs/litepicker/dist/litepicker.js?1692870487') }}"></script>
    <script>
        const picker = new Litepicker({
            element: document.getElementById('datepicker-icon'),
            format: 'YYYY-MM-DD',
            showDropdowns: true,
            showWeekNumbers: false,
            singleMode: true,
            autoApply: true,
            autoRefresh: true,
            lang: 'vi-VN',
            mobileFriendly: true,
            resetButton: true,
            autoRefresh: true,
            dropdowns: {
                minYear: null,
                maxYear: null,
                months: true,
                years: true
            },
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    console.log(date1, date2);
                });
            }
        });
    </script>
    <script>
        $('form').submit(function() {
            $('.btn-2').attr('disabled', true);
            $('.btn-2').html(
                `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Đang cập nhật...`
            );
        });

        //preview image
        $('input[type="file"]').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.avatar').css('background-image', 'url(' + e.target.result + ')');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush
