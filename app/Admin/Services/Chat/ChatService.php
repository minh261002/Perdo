<?php

namespace App\Admin\Services\Chat;

use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use App\Events\SendMessageEvent;
use Illuminate\Support\Facades\Event;

class ChatService implements ChatServiceInterface
{
    protected $messageRepository;
    protected $conversationRepository;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
    ) {
        $this->messageRepository = $messageRepository;
    }

    public function send(Request $request)
    {
        $data = $request->validated();
        $messageData = $this->messageRepository->create($data);

        $event = new SendMessageEvent(
            $messageData->message,
            $messageData->file,
            $messageData->receiver_id,
            $messageData->sender_id,
            $messageData->created_at
        );

        Event::dispatch($event);
    }
}