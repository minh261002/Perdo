<header class="navbar navbar-expand-md d-print-none position-sticky top-0" style="z-index: 1020;">
    <div class="container-xl">
        <p data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart">
            <i class="ti ti-menu-2 fs-1"></i>
        </p>

        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="/">
                <img src="{{ asset('/images/logo.svg') }}" class="img-fluid" width="90px" />
            </a>
        </div>

        <div class="navbar-nav flex-row order-md-last gap-3">
            <div class="nav-item">
                <a href="" class="position-relative text-decoration-none">
                    <i class="ti ti-shopping-cart  d-block w-100 h-100" style="font-size: 30px"></i>
                    <span
                        class="badge bg-red text-red-fg position-absolute top-0 start-100 translate-middle badge-circle">1</span>
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


<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart" aria-labelledby="offcanvasStartLabel">
    <div class="offcanvas-header">
        <img src="{{ asset('/images/logo.svg') }}" class="img-fluid" width="60px" />
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="navbar-search d-flex d-md-none w-100">
            <div class="input-group input-group-merge search-bar">
                <input type="text" class="form-control" placeholder="Tìm kiếm" aria-label="Search…"
                    aria-describedby="topbar-addon">
                <button class="input-group-text btn btn-primary" id="topbar-addon">
                    <span class="ti ti-search"></span>
                </button>
            </div>
        </form>
        <div class="mt-3">
            <div class="navbar">
                <div class="container-xl">
                    <div class="row flex-fill align-items-center justify-content-center">
                        <ul class="navbar-nav align-items-center justify-content-center">
                            <li class="nav-item active">
                                <a class="nav-link" href="./">
                                    <span class="nav-link-title"> Trang chủ </span>
                                </a>
                            </li>

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
    </div>
</div>
