<?php

namespace App\Services\Profile;

use App\Repositories\User\UserRepositoryInterface;
use App\Supports\UploadFile;
use Illuminate\Http\Request;

class ProfileService implements ProfileServiceInterface
{
    use UploadFile;

    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;

        if ($image) {
            $data['image'] = $this->uploadImage($image, '/uploads/images/avatars');
        }

        $this->repository->update(auth()->guard('web')->id(), $data);

        return true;
    }
}