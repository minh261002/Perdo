<?php

namespace App\Supports;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait UploadFile
{
    function uploadImage(Request|UploadedFile $input, string $path = 'uploads', ?string $oldPath = null): ?string
    {
        // Kiểm tra kiểu dữ liệu
        $image = $input instanceof Request ? $input->file('image') : $input;

        if ($image instanceof UploadedFile) {
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            // Tạo thư mục nếu chưa tồn tại
            $destinationPath = public_path($path);
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            try {
                $image->move($destinationPath, $imageName);
            } catch (\Exception $e) {
                return null;
            }

            return $path . '/' . $imageName;
        }

        return null;
    }
}