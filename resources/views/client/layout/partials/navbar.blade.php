@php
    $user = Auth::guard('web')->user();
    $cart_count = session()->has('cart') ? count(session('cart')) : 0;
@endphp





@push('styles')
    <style>
        @media all and (min-width: 992px) {
            .dropdown-menu li {
                position: relative;
            }

            .nav-item .submenu {
                display: none;
                position: absolute;
                left: 100%;
                top: -7px;
            }

            .nav-item .submenu-left {
                right: 100%;
                left: auto;
            }

            .dropdown-menu>li:hover {
                background-color: blue;
            }

            .dropdown-menu>li:hover>.submenu {
                display: block;
            }
        }

        @media (max-width: 991px) {
            .dropdown-menu .dropdown-menu {
                margin-left: 0.7rem;
                margin-right: 0.7rem;
                margin-bottom: .5rem;
            }
        }
    </style>
@endpush


<div class="navbar navbar-expand-md d-print-none position-sticky top-0" style="z-index: 1020;">
    <div class="container-xl">
        <p data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart"
            class="d-block d-md-none">
            <i class="ti ti-menu-2 fs-1"></i>
        </p>
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
                <a href="{{ route('cart.index') }}" class="position-relative text-decoration-none" id="cart-icon">
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

                        <a href="{{ route('profile.index') }}" class="dropdown-item">Thông tin cá nhân</a>
                        <a href="{{ route('profile.change.password.form') }}" class="dropdown-item">Đổi mật khẩu</a>
                        <a href="{{ route('profile.orders') }}" class="dropdown-item">Đơn hàng</a>
                        {{-- <a href="{{ route('wishlist.index') }}" class="dropdown-item">Yêu thích</a> --}}

                        <div class="dropdown-divider m-0"></div>
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
</div>

<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="row flex-fill align-items-center justify-content-center">
                    <ul class="navbar-nav align-items-center justify-content-center">
                        <li class="nav-item active">
                            <a class="nav-link" href="./">
                                <span class="nav-link-title"> Trang chủ </span>
                            </a>
                        </li>
                        @foreach ($categories as $category)
                            @if ($category->children->count() > 0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle"
                                        href="{{ route('category.index', $category->slug) }}"
                                        data-bs-toggle="dropdown">{{ $category->name }}</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($category->children as $child)
                                            @if ($child->children->count() > 0)
                                                <li>
                                                    <a class="dropdown-item dropdown-toggle"
                                                        href="{{ route('category.index', $category->slug) }}">{{ $child->name }}</a>
                                                    <ul class="dropdown-menu">
                                                        @foreach ($child->children as $subChild)
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('category.index', $category->slug) }}">{{ $subChild->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('category.index', $category->slug) }}"
                                                        }}">{{ $child->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('category.index', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="./">
                                <span class="nav-link-title"> Bài viết </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
