<?php

namespace App\Admin\Http\Requests\Transport;

use App\Admin\Http\Requests\BaseRequest;

class TransportRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'method' => 'required',
        ];
    }
}