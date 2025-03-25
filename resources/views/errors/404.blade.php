<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        404 Page Not Found
    </title>
    <link href="{{ asset('/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/icons/tabler-icons-filled.css') }}">
    <link rel="stylesheet" href="{{ asset('/icons/tabler-icons.css') }}">
    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" type="image/x-icon">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="empty-header">
                    404 Page Not Found
                </div>
                <p class="empty-title">
                    Oops… This page is not found 🙇‍♂️
                </p>
                <p class="empty-subtitle text-secondary">
                    The page you are looking for might have been removed, had its name changed, or is temporarily
                    Contact the administrator if you think this is a mistake.
                </p>

                <div class="empty-action">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">
                        <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l14 0" />
                            <path d="M5 12l6 6" />
                            <path d="M5 12l6 -6" />
                        </svg>
                        Take me home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
