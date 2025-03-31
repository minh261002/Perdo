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

    var userId = '{{ Auth::guard('web')->user()->id ?? 0 }}';

    var channel = pusher.subscribe(`App.Models.User.${userId}`);

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
                </div>
            </div>
        `;

        if ($('#empty-notification').length > 0) {
            $('#empty-notification').remove();
        }
        $('#notification-list').prepend(html);
        $('#notification-list-box').prepend(html);
    });
</script>
