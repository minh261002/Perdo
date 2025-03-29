<div class="card border-0">
    <div class="card-body p-0">

        <div class="row">
            @foreach ($brands as $item)
                <div class="col-6 col-md-2 gap-y-3 m-0 p-0 ">
                    <a href="{{ route('brand.index', $item->slug) }}">
                        <img src="{{ asset($item->logo) }}" alt="{{ $item->name }}" class="w-100 brand-image">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
