<?php

namespace App\Supports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait UploadFile
{
    function uploadImage(Request $request, string $inputName, ?string $oldPath = null, string $path = 'uploads'): ?string
    {
        if ($request->hasFile($inputName)) {
            $image = $request->file($inputName);

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