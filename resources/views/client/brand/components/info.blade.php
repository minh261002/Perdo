<div class="shop-banner d-flex align-items-center justify-content-md-between justify-content-center gap-3"
    style="background-image: url('{{ $brand->banner }}'); background-size: cover; background-position: center;">

    <div class="d-flex align-items-center justify-content-start gap-3 bg-light py-3 px-5 rounded-3 border">
        <a href="{{ route('brand.index', $brand->slug) }}"> <img src="{{ $brand->logo }}" alt="Logo"
                class="rounded-circle bg-light logo-brand border">
        </a>

        <div class="shop-info">
            <h4>
                <a href="{{ route('brand.index', $brand->slug) }}"
                    class="text-decoration-none text-primary fs-1">{{ $brand->name }}</a>
            </h4>
            <span class="badge badge-custom">Chính Hãng</span>
        </div>
    </div>


    <div class=" py-3 px-5 rounded-3 border" style="background-color: rgba(255, 255, 255, 0.8);">
        <ul class="list-unstyled mb-0">
            <li class="fs-3 fw-bold text-primary">
                <i class="ti ti-check me-1"></i>
                100% chất lượng
            </li>
            <li class="fs-3 fw-bold text-primary"> <i class="ti ti-check me-1"></i>
                Phân phối chính hãng</li>
            <li class="fs-3  fw-bold text-primary"> <i class="ti ti-check me-1"></i>
                Đổi trả dễ dàng</li>

            <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Giới thiệu về {{ $brand->name }}
            </button>
        </ul>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $brand->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! $brand->description ?? 'Không có giới thiệu thương hiệu' !!}
                </div>
            </div>
        </div>
    </div>
</div>
