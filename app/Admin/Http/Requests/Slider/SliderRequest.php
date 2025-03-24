<?php

namespace App\Admin\Http\Requests\Slider;

use App\Admin\Http\Requests\BaseRequest;

class SliderRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'name' => 'required',
            'desc' => 'nullable',
            'status' => 'required',
            'key' => 'required|unique:sliders,key',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required|exists:sliders,id',
            'name' => 'required',
            'desc' => 'nullable',
            'status' => 'required',
            'key' => 'required|unique:sliders,key,' . $this->id,
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Vui lòng nhập ID',
            'id.exists' => 'ID không tồn tại',
            'name.required' => 'Vui lòng nhập tên slider',
            'status.required' => 'Vui lòng chọn trạng thái',
        ];
    }
}
