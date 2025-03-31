<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="url-home" content="{{ url('/') }}" />
    <title>
        @yield('title')
    </title>
    <!-- CSS files -->
    <link href="{{ asset('/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/icons/tabler-icons-filled.css') }}">
    <link rel="stylesheet" href="{{ asset('/icons/tabler-icons.css') }}">
    <link rel="shortcut icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/css/toast@1.0.1/fuiToast.min.css">
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/libs/datatables/plugins/bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/libs/datatables/plugins/buttons/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/libs/datatables/plugins/responsive/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/owl.theme.green.min.css') }}">


    @stack('styles')

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>

    <script>
        const BASEURL = "{{ rtrim(env('APP_URL'), '/') }}/";

        function format_price(price) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(price);
        }
    </script>

</head>

<body>
    <script src="{{ asset('/js/demo-theme.min.js?1692870487') }}"></script>
    <div id="fui-toast"></div>
    @php
        $categories = \App\Models\Category::where('show_menu', true)
            ->whereNull('parent_id')
            ->defaultOrder()
            ->withDepth()
            ->get()
            ->toFlatTree();
    @endphp
    <div class="page ">
        @include('client.layout.partials.header-top')
        @include('client.layout.partials.navbar')

        @yield('content')

        @include('client.layout.partials.footer')



        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart" aria-labelledby="offcanvasStartLabel">
            <div class="offcanvas-header">
                <img src="{{ asset('/images/logo.svg') }}" class="img-fluid" width="60px" />
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
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
                                <ul class="navbar-nav align-items-center justify-content-left">
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
            </div>
        </div>

        @include('client.layout.partials.pusher')
    </div>


    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('libs/datatables/plugins/bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    <script src="{{ asset('libs/datatables/plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/plugins/buttons/js/buttons.bootstrap5.min.js') }}"></script>

    <script src="{{ asset('libs/datatables/plugins/responsive/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables/plugins/responsive/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/js/setup.js') }}"></script>

    <!-- Libs JS -->
    @stack('libs-js')
    <!-- Tabler Core -->
    <script src="{{ asset('/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('/js/demo.min.js?1692870487') }}" defer></script>

    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('plugins/ckfinder/ckfinder.js') }}"></script>
    <script src="{{ asset('/js/owl.carousel.min.js') }}"></script>

    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/lelinh014756/fui-toast-js@master/assets/js/toast@1.0.1/fuiToast.min.js"></script>

    <script>
        $(document).ready(function() {
            function fetchNotification() {
                $.ajax({
                    url: "{{ route('notification.get') }}",
                    type: 'GET',
                    success: function(response) {
                        const notificationsArr = response.data;

                        $('#notify-count').text(notificationsArr.length);

                        const notifications = Object.values(notificationsArr);
                        if (notifications.length > 0) {
                            notifications.forEach(element => {
                                $('#notification-list').append(`
                               <div class="list-group-item">
                                    <div class="row align-items-center">

                                        ${element.is_read ? '<div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>' : '<div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>'}

                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">
                                                ${element.title}
                                            </a>
                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                ${element.content.substring(0, 100)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                            });

                        }
                    }
                });
            }

            fetchNotification();
        })
    </script>

    @if (session('success'))
        <script>
            FuiToast.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            FuiToast.error('{{ session('error') }}');
        </script>
    @endif

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                FuiToast.error('{{ $error }}');
            @endforeach
        </script>
    @endif

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&language=vi&callback=initMaps">
    </script>
    <script>
        function initMaps() {
            try {
                if (typeof initMap === 'function') {
                    console.log("Calling initMap");
                    initMap();
                } else {
                    console.error("initMap is not defined");
                }

            } catch (error) {
                console.error("Error in initMaps:", error);
                window.location.reload();
            }
        }
    </script>
    @stack('scripts')
</body>

</html>
