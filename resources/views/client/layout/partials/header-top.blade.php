@php
    $user = Auth::guard('web')->user();
    $cart_count = session()->has('cart') ? count(session('cart')) : 0;
@endphp

<header class="navbar navbar-expand-md d-print-none position-sticky top-0" style="z-index: 1020;">
    <div class="container-xl">
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="/">
                <img src="{{ asset('/images/logo.svg') }}" class="img-fluid" width="90px" />
            </a>
        </div>
        <form class="navbar-search d-none d-md-flex ms-2 w-50">
            <div class="input-group input-group-merge search-bar">
                <input type="text" class="form-control" placeholder="Tìm kiếm" aria-label="Search…"
                    aria-describedby="topbar-addon">
                <button class="input-group-text btn btn-primary" id="topbar-addon">
                    <span class="ti ti-search"></span>
                </button>
            </div>
        </form>
        <div class="navbar-nav flex-row order-md-last gap-3">
            <div class="nav-item">
                <a href="{{ route('cart.index') }}" class="position-relative text-decoration-none">
                    <i class="ti ti-shopping-cart  d-block w-100 h-100" style="font-size: 30px"></i>
                    <span
                        class="badge bg-red text-red-fg position-absolute top-0 start-100 translate-middle badge-circle"
                        id="cart-count">
                        {{ $cart_count }}
                    </span>
                </a>
            </div>
            @if (Auth::guard('web')->check())
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url('{{ $user->image }}')"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>
                                {{ $user->name }}
                            </div>
                            <div class="mt-1 small text-secondary">
                                Khách hàng
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">


                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <span class="avatar avatar-sm"
                            style="background-image: url('{{ asset('/images/not-found.jpg') }}')"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>Tài khoản</div>
                            <div class="mt-1 small text-secondary">
                                Khách hàng
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ route('login') }}" class="dropdown-item">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="dropdown-item">Đăng ký</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>
