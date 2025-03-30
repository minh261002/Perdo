<?php

namespace App\Admin\Http\Requests\Notification;

use App\Admin\Http\Requests\BaseRequest;

class NotificationRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'objects' => 'required',
            'user_types' => 'nullable',
            'user_id' => 'nullable',
            'admin_types' => 'nullable',
            'admin_id' => 'nullable',
            'title' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'objects.required' => 'Vui lòng chọn đối tượng nhận thông báo',
            'user_types.required' => 'Vui lòng chọn loại thông báo cho người dùng',
            'user_id.required' => 'Vui lòng chọn người dùng',
            'admin_types.required' => 'Vui lòng chọn loại thông báo cho quản trị viên',
            'admin_id.required' => 'Vui lòng chọn quản trị viên',
            'title.required' => 'Vui lòng nhập tiêu đề thông báo',
            'content.required' => 'Vui lòng nhập nội dung thông báo',
            'user_types.array' => 'Loại thông báo cho người dùng phải là một mảng',
            'user_types.*.in' => 'Loại thông báo cho người dùng không hợp lệ',
            'admin_types.array' => 'Loại thông báo cho quản trị viên phải là một mảng',
        ];
    }
}