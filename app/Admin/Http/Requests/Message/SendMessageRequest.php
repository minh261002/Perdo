<?php

namespace App\Admin\Http\Requests\Message;

use App\Admin\Http\Requests\BaseRequest;

class SendMessageRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'sender_id' => 'required|exists:admins,id',
            'receiver_id' => 'required|exists:admins,id',
            'message' => 'nullable',
            'file' => 'nullable'
        ];
    }
}
