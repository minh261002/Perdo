<div class="container mb-30px">
    <div class="card border-0">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center gap-2 mb-5">
                <img src="{{ asset('images/icon-title.svg') }}" alt="">
                <h1 class="d-inline-block mb-0 text-primary fs-1">Thương hiệu nổi bật</h1>
                <img src="{{ asset('images/icon-title.svg') }}" alt="">
            </div>

            <div class="row">
                @foreach ($homeBrand as $item)
                    <div class="col-6 col-md-2 gap-y-3 m-0 p-0 ">
                        <a href="{{ route('brand.index', $item->slug) }}">
                            <img src="{{ asset($item->logo) }}" alt="{{ $item->name }}" class="w-100 brand-image">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
