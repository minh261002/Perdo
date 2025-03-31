<div class="col-12 col-md-2 border-end">
    <div class="card-body">
        <div class="list-group list-group-transparent">
            <a href="{{ route('profile.index') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ setSidebarActive(['profile.index']) }}">
                Thông tin cá nhân
            </a>

            <a href="{{ route('profile.change.password.form') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ setSidebarActive(['profile.change.password.form']) }}">
                Đổi mật khẩu
            </a>

            <a href="{{ route('profile.orders') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ setSidebarActive(['profile.orders', 'profile.order.detail']) }}">
                Đơn hàng
            </a>

            <a href="{{ route('profile.notifications') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ setSidebarActive(['profile.notifications']) }}">
                Thông báo
            </a>

            <a href="{{ route('profile.discounts') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ setSidebarActive(['profile.discounts']) }}">
                Mã giảm giá
            </a>

            <a href="{{ route('profile.wishlists') }}"
                class="list-group-item list-group-item-action d-flex align-items-center {{ setSidebarActive(['profile.wishlists']) }}">
                Yêu thích
            </a>
        </div>
    </div>
</div>
