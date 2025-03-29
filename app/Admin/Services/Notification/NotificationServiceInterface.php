<?php

namespace App\Admin\Services\Notification;
use Illuminate\Http\Request;

interface NotificationServiceInterface
{
    public function notification(Request $request);
}