<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $message;
    public $file;
    public $receiverId;
    public $senderId;
    public $createdAt;

    public function __construct(
        $message,
        $file,
        $receiverId,
        $senderId,
        $createdAt
    ) {
        $this->message = $message;
        $this->file = $file;
        $this->receiverId = $receiverId;
        $this->senderId = $senderId;
        $this->createdAt = $createdAt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel("App.Models.Admin.{$this->receiverId}");
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'file' => $this->file,
            'receiverId' => $this->receiverId,
            'senderId' => $this->senderId,
            'createdAt' => $this->createdAt,
        ];
    }

    public function broadcastAs(): string
    {
        return 'message';
    }
}