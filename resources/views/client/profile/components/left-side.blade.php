<div class="col-12 col-md-3 border-end">
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
        </div>
    </div>
</div>
