<?php

namespace App\Http\Controllers;

use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $repository;

    public function __construct(
        NotificationRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function get()
    {
        $notifications = $this->repository->getByQueryBuilder([
            'user_id' => auth()->guard('web')->user()->id,
            'is_read' => false
        ])->paginate(5);

        return response()->json([
            'status' => 'success',
            'data' => $notifications,
        ]);
    }

    public function readAll(Request $request)
    {
        $notifications = $this->repository->getByQueryBuilder([
            'user_id' => auth()->guard('web')->user()->id,
            'is_read' => false
        ])->get();

        foreach ($notifications as $notification) {
            $notification->update(['is_read' => true]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đánh dấu tất cả thông báo là đã đọc',
        ]);
    }
}
