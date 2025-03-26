<div class="container my-30px">
    <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($homeSlider->items as $key => $item)
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="{{ $key }}"
                    class="{{ $key == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($homeSlider->items as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img class="d-block w-100 rounded-2" alt="" src="{{ $item->image }}" />
                </div>
            @endforeach
        </div>

        <a class="carousel-control-prev" data-bs-target="#carousel-sample" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" data-bs-target="#carousel-sample" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>

</div>
