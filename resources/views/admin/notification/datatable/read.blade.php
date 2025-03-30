@if ($is_read)
    <span class="badge bg-green text-white">{{ __('Đã đọc') }}</span>
@else
    <span class="badge bg-red text-white">{{ __('Chưa đọc') }}</span>
@endif
