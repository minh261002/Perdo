<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
        },
    });
    Pusher.logToConsole = true;

    var adminId = '{{ Auth::guard('web')->user()->id ?? 0 }}';

    var channel = pusher.subscribe(`App.Models.User.${adminId}`);

    // channel.bind('App\\Events\\NotificationEvent', function(data) {
    //     var audio = new Audio('{{ asset('audio.mp3') }}');
    //     audio.muted = true;
    //     audio.play().then(() => {
    //         audio.muted = false;
    //     }).catch(error => {
    //         console.error('Audio playback failed:', error);
    //     });

    //     FuiToast.success('Bạn có thông báo mới từ ' + data.body.adminName, {
    //         duration: 5000,
    //     });

    //     $('#notify-count').text(parseInt($('#notify-count').text()) + 1);

    //     let html = `
    //         <div class="list-group-item box-noty-${data.body['notyId']} notification-item" data-notification-id="${data.body['notyId']}">
    //             <div class="row align-items-center">
    //                 <div class="col-auto">
    //                     <span class="status-dot status-dot-animated bg-green d-block"></span>
    //                 </div>
    //                 <div class="col text-truncate">
    //                     <a href="#" class="text-body d-block">
    //                         ${data.title}
    //                     </a>
    //                     <div class="d-block text-secondary text-truncate mt-n1">
    //                         ${data.body['content'].substring(0, 100)}
    //                     </div>
    //                 </div>

    //                 <div class="col-auto">
    //                     <a href="#" class="delete-notification text-danger" data-notyid="${data.body['notyId']}">
    //                         <i class="ti ti-trash fs-1"></i>
    //                     </a>
    //                 </div>
    //             </div>
    //         </div>
    //     `;

    //     if ($('#empty-notification').length > 0) {
    //         $('#empty-notification').remove();
    //     }
    //     $('#notification-list').prepend(html);
    //     $('#notification-list-box').prepend(html);
    // });

    channel.bind('log', function(data) {
        //sự kiện user online
        alert('Có sự kiện mới');
    });
</script>
