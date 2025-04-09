<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher("3cc7a46e532c9e22baf5", {
        cluster: "ap1",
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
        },
    });
    Pusher.logToConsole = true;

    var userId = '{{ Auth::guard('admin')->user()->id ?? 0 }}';

    var channel = pusher.subscribe(`App.Models.Admin.${userId}`);

    channel.bind('notification', function(data) {
        FuiToast.success('Bạn có thông báo mới từ ' + data.body.adminName, {
            duration: 5000,
        });

        $('#notify-count').text(parseInt($('#notify-count').text()) + 1);

        let html = `
            <div class="list-group-item box-noty-${data.body['notyId']} notification-item" data-notification-id="${data.body['notyId']}">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="status-dot status-dot-animated bg-green d-block"></span>
                    </div>
                    <div class="col text-truncate">
                        <a href="#" class="text-body d-block">
                            ${data.title}
                        </a>
                        <div class="d-block text-secondary text-truncate mt-n1">
                            ${data.body['content'].substring(0, 100)}
                        </div>
                    </div>

                    <div class="col-auto">
                        <a href="#" class="delete-notification text-danger" data-notyid="${data.body['notyId']}">
                            <i class="ti ti-trash fs-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        `;

        if ($('#empty-notification').length > 0) {
            $('#empty-notification').remove();
        }
        $('#notification-list').prepend(html);
        $('#notification-list-box').prepend(html);
    });

    channel.bind('message', function(data) {
        let receiverId = $('.chat-bubbles').data('receiver-id');
        // if (receiverId == data.senderId) {
        let html = `
                <div class="chat-item">
                    <div class="row align-items-end justify-content-end">
                        <div class="col col-lg-6">
                            <div class="chat-bubble chat-bubble-me">
                                <div class="chat-bubble-body fw-medium fs-4">
                                    <p>${data.message}</p>
                                </div>
                                <div class="chat-bubble-title">
                                    <div class="row justify-content-end">
                                        <div class="col-auto chat-bubble-date">
                                            ${data.created_at}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        $('.chat-bubbles').append(html);
        $('.scrollable').animate({
            scrollTop: $('.scrollable')[0].scrollHeight
        }, 1000);
        // }
    });
</script>
