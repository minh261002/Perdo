<div class="card-header">
    <div class="row align-items-center justify-content-between w-100">
        <div class="col-auto">
            <span class="avatar avatar-1" style="background-image: url('{{ $chatAdmin->image }}')"></span>
        </div>

        <div class="col text-truncate">
            <h4 class="mb-0">
                {{ $chatAdmin->name }}
            </h4>
            <span class="text-secondary fs-5">Online</span>
        </div>
        <div class="col-auto">
            <i class="ti ti-phone-call text-secondary fs-1"></i>
            <i class="ti ti-trash text-secondary fs-1 ms-3 text-danger"></i>
        </div>
    </div>
</div>
<div class="card-body scrollable" style="height: 60vh;">
    <div class="chat"
        style="height: 100%; overflow: auto;scrollbar-width: thin;scrollbar-color: transparent transparent;-ms-overflow-style: none;overflow: -moz-scrollbars-none;-webkit-overflow-scrolling: touch;">
        <div class="chat-bubbles" data-receiver-id="{{ $chatAdmin->id }}">
            @foreach ($messages as $message)
                <div class="chat-item">
                    <div
                        class="row align-items-end {{ $message->sender_id === auth()->guard('admin')->id() ? 'justify-content-end' : '' }}">
                        <div class="col col-lg-6">
                            <div
                                class="chat-bubble {{ $message->sender_id === auth()->guard('admin')->id() ? 'chat-bubble-me' : '' }}">
                                <div class="chat-bubble-body fw-medium fs-4">
                                    <p>{{ $message->message }}</p>
                                </div>
                                <div class="chat-bubble-title">
                                    <div class="row justify-content-end">
                                        <div class="col-auto chat-bubble-date">
                                            {{ format_datetime_ago($message->created_at) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="card-footer position-relative">
    <div class="input-group input-group-flat">
        <input type="text" name="message" class="form-control" autocomplete="off" placeholder="Nhập tin nhắn..."
            id="message">
        <span class="input-group-text">
            <i class="ti ti-mood-smile fs-1 me-2" id="pick-emoji" style="cursor:pointer"></i>
            <i class="ti ti-paperclip fs-1 me-2" style="cursor:pointer"></i>
            <i class="ti ti-send fs-1" id="send-mesage" style="cursor:pointer"></i>
        </span>
    </div>

    <div class="position-absolute bottom-100 end-0 d-none" id="emoji-picker-container">
        <emoji-picker id="emoji-picker"></emoji-picker>
    </div>
</div>

<script>
    const emojiPickerContainer = document.getElementById('emoji-picker-container');
    const emojiPicker = document.getElementById('emoji-picker');
    const pickEmoji = document.getElementById('pick-emoji');
    const messageInput = document.getElementById('message');

    pickEmoji.addEventListener('click', () => {
        emojiPickerContainer.classList.toggle('d-none');
        emojiPickerContainer.classList.toggle('d-block');
    });
    emojiPicker.addEventListener('emoji-click', (event) => {
        const emoji = event.detail.unicode;
        messageInput.value += emoji;
    });
    document.addEventListener('click', (event) => {
        if (!emojiPickerContainer.contains(event.target) && !pickEmoji.contains(event.target)) {
            emojiPickerContainer.classList.add('d-none');
            emojiPickerContainer.classList.remove('d-block');
        }
    });

    messageInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const message = messageInput.value;
            if (message.trim() !== '') {
                sendMessage(message);
                messageInput.value = '';
            }

            document.querySelector('.chat').scrollTop = document.querySelector('.chat').scrollHeight;
        }
    });

    document.getElementById('send-mesage').addEventListener('click', function() {
        const message = messageInput.value;
        if (message.trim() !== '') {
            sendMessage(message);
            messageInput.value = '';
        }
        document.querySelector('.chat').scrollTop = document.querySelector('.chat').scrollHeight;
    });

    async function sendMessage(message) {
        const senderId = {{ auth()->guard('admin')->id() }};
        const receiverId = {{ $chatAdmin->id }};

        // Hiển thị tin nhắn mới trên UI
        const chatBubble = document.createElement('div');
        chatBubble.classList.add('chat-bubble', 'chat-bubble-me');
        chatBubble.innerHTML = `
        <div class="chat-bubble-body fw-medium fs-4">
            <p>${message}</p>
        </div>
        <div class="chat-bubble-title">
            <div class="row justify-content-end">
                <div class="col-auto chat-bubble-date">
                    ${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                </div>
            </div>
        </div>
    `;

        const chatItem = document.createElement('div');
        chatItem.classList.add('chat-item');
        const chatRow = document.createElement('div');
        chatRow.classList.add('row', 'align-items-end', 'justify-content-end');
        const chatCol = document.createElement('div');
        chatCol.classList.add('col', 'col-lg-6');
        chatCol.appendChild(chatBubble);
        chatRow.appendChild(chatCol);
        chatItem.appendChild(chatRow);

        const chatBubbles = document.querySelector('.chat-bubbles');
        chatBubbles.appendChild(chatItem);
        chatBubbles.scrollTop = chatBubbles.scrollHeight;


        $.ajax({
            url: '{{ route('admin.chat.send') }}',
            type: 'POST',
            data: {
                message: message,
                sender_id: senderId,
                receiver_id: receiverId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Message sent successfully:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', error);
            }
        });
    }
</script>
