{{-- {{ $query->price }} --}}

@if ($query->sale_price)
    <span class="text-danger">{{ format_price($query->sale_price) }}</span>
    <del>{{ format_price($query->price) }}</del>
@else
    {{ format_price($query->price) }}
@endif
