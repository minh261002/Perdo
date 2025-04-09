@extends('admin.layouts.master')

@section('title', 'Tin nhắn')

@section('content')
    <div class="container-fluid flex-fill d-flex flex-column my-4">
        <div class="card flex-fill">
            <div class="row g-0 flex-fill">
                <div class="col-12 col-lg-5 col-xl-3 border-end d-flex flex-column">
                    <div class="card-header d-none d-md-block">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Tìm kiếm..." aria-label="Tìm kiếm">
                        </div>
                    </div>
                    <div class="card-body p-0 scrollable flex-fill">
                        <div class="nav flex-column nav-pills" role="tablist">
                            @forelse ($admins as $admin)
                                @php
                                    $lastMessage = $admin->lastMessageWith(auth()->guard('admin')->user()->id);
                                @endphp
                                <a href="javascript:void(0)"
                                    class="nav-link text-start mw-100 p-3 {{ !$lastMessage->is_read ? 'active' : '' }} box-conversation"
                                    data-admin-id="{{ $admin->id }}">

                                    <div class="row align-items-center flex-fill">
                                        <div class="col-auto">
                                            <span class="avatar avatar-1"
                                                style="background-image: url('{{ $admin->image }}')"></span>
                                        </div>
                                        <div class="col text-body">
                                            <div>{{ $admin->name }}</div>
                                            <div class="text-secondary text-truncate w-100">
                                                {{ limit_text($lastMessage->message) }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center text-secondary p-3">
                                    <p>Không có tin nhắn nào.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7 col-xl-9 d-flex flex-column position-relative" id="conversation">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center" id="no-conversation">
                        <img src="{{ asset('images/conversation.webp') }}" class="img-fluid" alt="No conversation">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script>
        $(document).ready(function() {
            $('.box-conversation').on('click', function() {
                var adminId = $(this).data('admin-id');
                var url = "{{ route('admin.chat.show', ':id') }}";
                url = url.replace(':id', adminId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#conversation').html(response);
                        $('.chat').scrollTop($('.chat')[0].scrollHeight);
                        $('#no-conversation').hide();
                        $('.box-conversation').removeClass('active');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        })
    </script>
@endpush
