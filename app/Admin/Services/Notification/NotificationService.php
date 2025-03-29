<?php

namespace App\Admin\Services\Notification;

use App\Enums\ActiveStatus;
use App\Enums\Notification\NotificationObj;
use App\Enums\Notification\NotificationType;
use App\Events\NotificationEvent;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class NotificationService implements NotificationServiceInterface
{
    protected $repository;

    protected $adminRepository;

    protected $userRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        AdminRepositoryInterface $adminRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->repository = $repository;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
    }

    public function notification(Request $request)
    {
        $data = $request->validated();
        $notificationTypes = $data['objects'];

        switch ($notificationTypes) {
            case NotificationObj::All->value:
                $this->notifyAll($data);
                break;
            case NotificationObj::User->value:
                $this->notifyUsers($data);
                break;
            case NotificationObj::Admin->value:
                $this->notifyAdmins($data);
                break;
            default:
                break;
        }
    }

    protected function notifyAll($data)
    {
        $users = $this->userRepository->getByQueryBuilder([
            'status' => ActiveStatus::Active->value,
        ])->get();
        $admins = $this->adminRepository->getQueryBuilderOrderBy()->get();

        foreach ($users as $user) {
            $this->sendNotification($data, $user->id);
        }

        foreach ($admins as $admin) {
            $adminId = \Auth::guard('admin')->user()->id;
            if ($admin->id == $adminId) {
                continue;
            }
            $this->sendNotification($data, $admin->id, true);
        }
    }

    protected function notifyUsers($data)
    {
        if ($data['user_types'] == NotificationType::All->value) {
            $users = $this->userRepository->getByQueryBuilder([
                'status' => ActiveStatus::Active->value,
            ])->get();
            foreach ($users as $user) {
                $this->sendNotification($data, $user->id);
            }
        } else {
            foreach ($data['user_id'] as $userId) {
                $this->sendNotification($data, $userId);
            }
        }
    }

    protected function notifyAdmins($data)
    {
        if ($data['admin_types'] == NotificationType::All->value) {
            $admins = $this->adminRepository->getQueryBuilderOrderBy()->get();
            foreach ($admins as $admin) {
                $adminId = \Auth::guard('admin')->user()->id;
                if ($admin->id == $adminId) {
                    continue;
                }
                $this->sendNotification($data, $admin->id, true);
            }
        } else {
            foreach ($data['admin_id'] as $adminId) {
                $this->sendNotification($data, $adminId, true);
            }
        }
    }

    protected function sendNotification($data, $recipientId, $isAdmin = false)
    {
        if ($isAdmin) {
            $data['admin_id'] = $recipientId;
            $data['user_id'] = null;
        } else {
            $data['user_id'] = $recipientId;
            $data['admin_id'] = null;
        }
        $noty = $this->repository->create($data);

        $body = [
            'content' => $noty->content,
            'created_at' => $noty->created_at,
            'notyId' => $noty->id,
            'adminName' => \Auth::guard('admin')->user()->name,
        ];

        $event = new NotificationEvent(
            $noty->title,
            $body,
            $isAdmin ? $noty->admin_id : $noty->user_id,
            $isAdmin ? 'admin' : 'user',
        );

        //ghi log body
        \Log::info(json_encode($body));

        Event::dispatch($event);
    }


    public function read($request)
    {
        $data = $request->all();
        $id = $data['id'];
        $admin_id = $data['admin_id'];

        $noty = $this->repository->find($id);

        if ($noty->admin_id == $admin_id) {
            $noty->update(['is_read' => true]);
        }

        return $noty;
    }

    public function readAll($request)
    {
        dd($request->all());
    }
}