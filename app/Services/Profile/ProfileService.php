<?php

namespace App\Services\Profile;

use App\Repositories\User\UserRepositoryInterface;
use App\Supports\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function updatePassword(Request $request)
    {
        $data = $request->validated();


        if (!Hash::check($data['current_password'], auth()->guard('web')->user()->password)) {
            return [
                'type' => 'error',
                'message' => 'Mật khẩu hiện tại không chính xác'
            ];
        } elseif (Hash::check($data['password'], auth()->guard('web')->user()->password)) {
            return [
                'type' => 'error',
                'message' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại'
            ];
        }

        $this->repository->update(auth()->guard('web')->id(), [
            'password' => Hash::make($data['password'])
        ]);

        return [
            'type' => 'success',
            'message' => 'Đổi mật khẩu thành công'
        ];
    }
}