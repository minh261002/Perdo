@switch($method)
    @case(\App\Enums\Transport\TransportMethod::GHTK->value)
        <img src="{{ asset('images/ghtk.png') }}" style="width: 100px" />
    @break

    @default
    @break
@endswitch
