<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    function format_datetime_ago(datetime) {
        const date = new Date(datetime);
        const now = new Date();
        const diff = Math.abs(now - date);
        const seconds = Math.floor(diff / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (days > 0) {
            return days + ' ngày trước';
        } else if (hours > 0) {
            return hours + ' giờ trước';
        } else if (minutes > 0) {
            return minutes + ' phút trước';
        } else {
            return seconds + ' giây trước';
        }
    }

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

        let html2 = `
            <div class="list-group-item bg-light">
                <div class="row align-items-center">
                        <div class="col text-truncate">
                            <a href="#" class="text-reset d-block">
                                ${data.title}
                            </a>
                            <div class="d-block text-secondary text-truncate mt-n1">
                                ${format_datetime_ago(data.body['created_at'])}
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="" class="btn btn-danger">
                                <i class="ti ti-trash"></i>
                            </a>
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
        $('#tbl_notification').prepend(html2);
    });
</script>
