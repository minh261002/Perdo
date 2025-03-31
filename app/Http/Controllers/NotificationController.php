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
        ])->get();

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

        return redirect()->back()->with('success', 'Đánh dấu tất cả thông báo là đã đọc');
    }

    public function delete($id)
    {
        $notification = $this->repository->find($id);
        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Xóa thông báo thành công');
        }

        return redirect()->back()->with('error', 'Thông báo không tồn tại');
    }

    public function deleteAll()
    {
        $notifications = $this->repository->getByQueryBuilder([
            'user_id' => auth()->guard('web')->user()->id,
        ])->get();

        foreach ($notifications as $notification) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'Xóa tất cả thông báo thành công');
    }
}