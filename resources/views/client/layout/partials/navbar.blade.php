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
        <form class="navbar-search d-none d-md-flex ms-2 w-50 position-relative" action={{ route('product.search') }}>
            <div class="input-group input-group-merge search-bar">
                <input type="text" class="form-control" placeholder="Tìm kiếm" aria-label="Search…" id="search-input"
                    name="q" value="{{ request('q') }}" autocomplete="off">
                <button class="input-group-text btn btn-primary" type="submit">
                    <span class="ti ti-search"></span>
                </button>

                <div id="search-results" class="position-absolute w-100 top-100 start-0 d-none">
                    <div class="card">
                        <div class="card-header py-2">
                            <div class="card-title">
                                <h5 class="mb-0">Kết quả tìm kiếm</h5>
                            </div>
                        </div>

                        <div class="card-body" id="search-results-body">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="navbar-nav
                    flex-row order-md-last gap-3">
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
                        <a href="{{ route('profile.change.password.form') }}" class="dropdown-item">Đổi mật
                            khẩu</a>
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
                                                        href="{{ route('category.index', $category->slug) }}">{{ $child->name }}</a>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            let timeout;
            $('#search-input').on('input', function() {
                clearTimeout(timeout);
                let query = $(this).val();

                // Hiển thị loading
                $('#search-results-body').html(
                    '<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div>'
                );
                $('#search-results').removeClass('d-none');

                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('product.search.ajax') }}",
                        type: "GET",
                        data: {
                            q: query
                        },
                        success: function(response) {
                            $('#search-results').removeClass('d-none');
                            const products = response.data;

                            let html = '';
                            if (products.length > 0) {
                                html += '<div class="table-responsive">';
                                html +=
                                    '<table class="table table-vcenter text-nowrap">';
                                html += '<tbody>';

                                products.forEach(function(product) {
                                    html += '<tr>';
                                    html +=
                                        '<td class="text-center"><img src="' +
                                        product.image +
                                        '" alt="' + product.name +
                                        '" class="img-fluid" width="50px"></td>';
                                    html +=
                                        '<td><a href="/san-pham/' + product
                                        .slug +
                                        '" class="text-decoration-none">' +
                                        product.name + '</a></td>';
                                    html += '</tr>';
                                });

                                html += '</tbody>';
                                html += '</table>';
                                html += '</div>';
                            } else {
                                html =
                                    '<div class="alert alert-primary" role="alert">Không tìm thấy sản phẩm nào</div>';
                            }
                            $('#search-results-body').html(html);
                        },
                        error: function() {
                            $('#search-results-body').html(
                                '<div class="alert alert-danger">Đã xảy ra lỗi, vui lòng thử lại sau!</div>'
                            );
                        }
                    });
                }, 1000);
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#search-input, #search-results').length) {
                    $('#search-results').addClass('d-none');
                }
            });

            $('#search-input').on('focus', function() {
                if ($('#search-results-body').html().trim() !== '') {
                    $('#search-results').removeClass('d-none');
                }
            });
        })
    </script>
@endpush
