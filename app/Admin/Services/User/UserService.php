<?php

namespace App\Admin\Services\User;


use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        $data['image'] = $data['image'] ?? '/images/not-found.jpg';

        $data['password'] = Hash::make($data['password']);

        if ($data['birthday']) {
            $data['birthday'] = date('Y-m-d', strtotime($data['birthday']));
        }

        return $this->repository->create($data);
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        $data['image'] = $data['image'] ?? '/images/not-found.jpg';

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->repository->update($data['id'], $data);
    }

}
