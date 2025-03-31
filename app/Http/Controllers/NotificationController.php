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
}