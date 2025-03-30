<?php

namespace App\Admin\Http\Controllers\Notification;

use App\Admin\DataTables\Notification\NotificationDataTable;
use App\Admin\Http\Requests\Notification\NotificationRequest;
use App\Admin\Services\Notification\NotificationServiceInterface;
use App\Enums\ActiveStatus;
use App\Enums\Notification\NotificationObj;
use App\Enums\Notification\NotificationType;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController
{
    protected $repository;
    protected $userRepository;
    protected $adminRepository;

    protected $service;

    public function __construct(
        NotificationRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        AdminRepositoryInterface $adminRepository,
        NotificationServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
        $this->service = $service;
    }

    public function index(NotificationDataTable $dataTable)
    {
        return $dataTable->render('admin.notification.index');
    }

    public function create()
    {
        $types = NotificationType::asSelectArray();
        $objects = NotificationObj::asSelectArray();
        $users = $this->userRepository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value,
        ])->get();
        $admins = $this->adminRepository->getQueryBuilderOrderBy()->get();

        return view('admin.notification.create', compact('types', 'users', 'admins', 'objects'));
    }

    public function store(NotificationRequest $request)
    {
        $this->service->notification($request);
        return redirect()->route('admin.notification.index')->with('success', 'Gửi thông báo thành công');
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'Xóa thông báo thành công']);
    }

    public function get()
    {
        $notifications = $this->repository->getByQueryBuilder([
            'user_id' => Auth::guard('web')->user()->id,
        ])->paginate(5);
        return response()->json($notifications);
    }
}
