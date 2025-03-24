@extends('admin.layouts.master')
@section('title', 'Quản lý quyền')

@push('styles')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý quyền
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-house"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Quản lý quyền
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Danh sách quyền
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.permission.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus fs-4 me-1"></i>
                            Thêm mới
                        </a>
                    </div>
                </div>

                <div class="text-danger" style="padding: 20px 20px 0 20px;">
                    <p>
                        <strong>Lưu ý:</strong>
                        <span>
                            Đây là phần chỉ dành riêng cho Nhà phát triển. Các Dev sẽ sử dụng slug ( permission_name )
                            để lập trình, đóng gói các chức năng để có thể phân quyền. Vui lòng không xóa hoặc điều
                            chỉnh các Quyền nếu bạn không phải Dev hoặc không biết về nó để tránh bị Lỗi toàn bộ hệ
                            thống.
                        </span>
                    </p>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin.layouts.partials.toggle-column')
                        {{ $dataTable->table(['class' => 'table table-bordered table-striped'], true) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('libs-js')
    <script src="{{ asset('js/buttons.server-side.js') }}"></script>
@endpush

@push('scripts')
    {{ $dataTable->scripts() }}

    @include('admin.layouts.partials.scripts', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
@endpush
