@extends('client.layout.master')

@section('title', 'Thông tin cá nhân')

@section('content')
    <div class="my-30px">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('client.profile.components.left-side')

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Mã giảm giá</h2>

                            <div class="row g-3 mt-3">
                                <div class="row row-cols-1 row-cols-md-3 gap-4">
                                    @forelse($discounts as $discount)
                                        <div class=" col-md-4">
                                            <div class="bg-blue-lt w-100 rounded-xl d-flex">

                                                <div class="d-flex flex-column  p-4 gap-2 w-100">
                                                    <h1 class="mb-0 fs-18px fw-bold text-primary">
                                                        {{ $discount->code }}
                                                    </h1>
                                                    <p class="mb-0 fs-12px text-secondary">
                                                        {{ $discount->description }}
                                                    </p>
                                                    <p class="mb-0 fs-12px text-secondary">Hết hạn:
                                                        {{ formatDate($discount->date_end) }}
                                                    </p>
                                                </div>

                                                <div class="d-flex flex-column justify-content-center position-relative w-50 border-start border-2 border-dashed border-gray align-items-center"
                                                    style="width:45%; max-width:30%;">

                                                    <div class="position-absolute bg-white rounded-circle"
                                                        style="width:35px; height:35px; top:-15%; left:-20%;"></div>

                                                    <a class="btn bg-blue text-white btn-icon"
                                                        style="width:45px; height:45px;">
                                                        <i class="ti ti-copy fs-18px"></i>
                                                    </a>

                                                    <div class="position-absolute bg-white rounded-circle"
                                                        style="width:35px; height:35px; bottom:-15%; left:-20%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="w-100 alert alert-light" role="alert">
                                            Không có mã giảm giá nào
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            {{ $discounts->withQueryString()->links('components.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
