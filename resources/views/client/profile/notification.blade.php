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
                            <h2 class="mb-4">Thông báo</h2>

                            <div class="row g-3 mt-3">
                                <div class="row  gap-4">
                                    <div class="list-group list-group-flush" id="tbl_notification">
                                        @forelse($notifications as $item)
                                            <div class="list-group-item {{ $item->is_read ? '' : 'bg-light' }}">
                                                <div class="row align-items-center">
                                                    <div class="col text-truncate">
                                                        <a href="#" class="text-reset d-block">
                                                            {{ $item->title }}
                                                        </a>
                                                        <div class="d-block text-secondary text-truncate mt-n1">
                                                            {{ format_datetime_ago($item->created_at) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <form method="POST"
                                                            action="{{ route('notification.delete', $item->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info" role="alert">
                                                Không có thông báo
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{ $notifications->withQueryString()->links('components.pagination') }}
                        </div>

                        <div class="card-footer d-flex justify-content-start gap-3">
                            <div>
                                <a href="{{ route('notification.read.all') }}" class="btn btn-success">
                                    Đánh dấu tất cả đã đọc
                                </a>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('notification.delete.all') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Xoá tất cả thông báo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        })
    </script>
@endpush
