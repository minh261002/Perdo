<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $body;
    public $title;
    public $id;
    public $type;

    /**
     * Create a new event instance.
     */
    public function __construct($title, $body, $id, $type)
    {
        $this->title = $title;
        $this->body = $body;
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            $this->type === 'admin'
            ? new PrivateChannel("App.Models.Admin.{$this->id}")
            : new PrivateChannel("App.Models.User.{$this->id}")
        ];
    }


    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'id' => $this->id,
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'notification';
    }
}
