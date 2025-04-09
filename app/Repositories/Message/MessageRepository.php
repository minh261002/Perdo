<?php

namespace App\Repositories\Message;

use App\Repositories\BaseRepository;
use App\Models\Message;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function getModel()
    {
        return Message::class;
    }
}
