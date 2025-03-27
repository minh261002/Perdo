@php
    $user = Auth::guard('web')->user();
@endphp

<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h1 class="mb-0 card-title">Thông tin khách hàng</h1>

        @if (!Auth::guard('web')->check())
            <a href="{{ route('login', ['redirect' => route('checkout.index')]) }}" class="nav-link">
                <i class="ti ti-user-circle fs-2 me-1"></i>
                Đăng nhập
            </a>
        @endif
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $user->name ?? '') }}" placeholder="Nhập họ và tên">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $user->email ?? '') }}" placeholder="Nhập email">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="{{ old('phone', $user->phone ?? '') }}" placeholder="Nhập số điện thoại">
                </div>
            </div>

            <div class="col-12 form-group mb-3">
                @include('components.pick-address', [
                    'label' => 'Địa chỉ cụ thể',
                    'name' => 'address',
                    'value' => old('address'),
                ])
                <input type="hidden" name="lat" value="{{ old('lat', $user->lat ?? '') }}">
                <input type="hidden" name="lng" value="{{ old('lng', $user->lng ?? '') }}">
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea class="form-control" id="note" name="note" rows="3" placeholder="Nhập ghi chú">{{ old('note') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
