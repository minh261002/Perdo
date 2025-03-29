<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="#tabs-desc-1" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                    Mô tả sản phẩm
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#tabs-review-1" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                    tabindex="-1">Đánh giá sản phẩm</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active show" id="tabs-desc-1" role="tabpanel">
                <div class="position-relative">
                    <div class="hidden-content" id="content">
                        {!! $product->desc ?? 'Sản phẩm này không có mô tả' !!}
                    </div>

                    @if ($product->desc)
                        <button id="toggleBtn" class="btn btn-secondary">Xem thêm</button>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="tabs-review-1" role="tabpanel">
                <h4>Profile tab</h4>
                <div>
                    Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam, sem
                    nunc amet, pellentesque id egestas velit sed
                </div>
            </div>
            <div class="tab-pane" id="tabs-settings-1" role="tabpanel">
                <h4>Settings tab</h4>
                <div>
                    Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit
                    mauris accumsan nibh habitant senectus
                </div>
            </div>
        </div>
    </div>
</div>
