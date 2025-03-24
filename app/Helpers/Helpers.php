<?php

use Illuminate\Support\Str;

if (!function_exists('limit_text')) {
    function limit_text($text, $limit = 100, $end = '...')
    {
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit);
            $text = substr($text, 0, strrpos($text, ' '));
            $text = $text . $end;
        }
        return $text;
    }
}

if (!function_exists('format_image_url')) {
    function formatImageUrl($url)
    {
        return url($url);
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($datetime)
    {
        return date('d/m/Y H:i:s', strtotime($datetime));
    }
}

if (!function_exists('format_date')) {
    function formatDate($date)
    {
        return date('d/m/Y', strtotime($date));
    }
}

if (!function_exists('format_time')) {
    function formatTime($time)
    {
        return date('H:i:s', strtotime($time));
    }
}

if (!function_exists('format_price')) {
    function format_price($price)
    {
        return number_format($price, 0, ',', '.') . ' ₫';
    }
}

if (!function_exists('setSidebarActive')) {

    function setSidebarActive(array $routes): ?string
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }

        return null;
    }
}

if (!function_exists('setSidebarShow')) {
    function setSidebarShow(array $routes): ?string
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'show';
            }
        }

        return null;
    }
}


function generate_text_depth_tree($depth, $word = '|--')
{
    return str_repeat($word, $depth);
}

if (!function_exists('format_datetime_ago')) {
    function format_datetime_ago($datetime)
    {
        $time = strtotime($datetime);
        $now = time();
        $diff = $now - $time;

        if ($diff < 60) {
            return $diff . ' giây trước';
        }

        $diff = round($diff / 60);
        if ($diff < 60) {
            return $diff . ' phút trước';
        }

        $diff = round($diff / 60);
        if ($diff < 24) {
            return $diff . ' giờ trước';
        }

        $diff = round($diff / 24);
        if ($diff < 30) {
            return $diff . ' ngày trước';
        }

        $diff = round($diff / 30);
        if ($diff < 12) {
            return $diff . ' tháng trước';
        }
    }
}

function uniqid_real($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new \Exception("no cryptographically secure random function available");
    }
    return Str::upper(substr(bin2hex($bytes), 0, $lenght));
}

if (!function_exists('limit_text')) {
    function limit_text($text, $limit = 100, $end = '...')
    {
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit);
            $text = substr($text, 0, strrpos($text, ' '));
            $text = $text . $end;
        }
        return $text;
    }
}
