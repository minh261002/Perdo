<?php

namespace App\Http\Controllers\Notification;

use App\Enums\ActiveStatus;
use App\Http\Requests\Notification\NotificationRequest;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Notification\NotificationServiceInterface;

class NotificationController
{
    protected $service;
    protected $repository;
    protected $userRepository;
    protected $customerRepository;

    public function __construct(
        NotificationServiceInterface $service,
        NotificationRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        UserRepositoryInterface $customerRepository
    ) {
        $this->service = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
    }

    public function create()
    {
        $admins = $this->userRepository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value
        ])->get();
        $users = $this->customerRepository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value
        ])->get();
        return view('notification.create', compact('admins', 'users'));
    }

    public function store(NotificationRequest $request)
    {
        $this->service->store($request);
        return redirect()->back()->with('success', 'Gửit thông báo thành công!');
    }
}
