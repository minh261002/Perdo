<?php

namespace App\Admin\Http\Requests\Slider;

use App\Admin\Http\Requests\BaseRequest;

class SliderItemRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'slider_id' => 'required|exists:sliders,id',
            'title' => 'required',
            'sub_title' => 'nullable',
            'button_text' => 'nullable',
            'link' => 'nullable',
            'position' => 'required',
            'image' => 'required',
            'mobile_image' => 'nullable',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required|exists:slider_items,id',
            'slider_id' => 'required|exists:sliders,id',
            'title' => 'required',
            'sub_title' => 'nullable',
            'button_text' => 'nullable',
            'link' => 'nullable',
            'position' => 'required',
            'image' => 'required',
            'mobile_image' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Vui lòng nhập ID',
            'id.exists' => 'ID không tồn tại',
            'slider_id.required' => 'Vui lòng chọn slider',
            'slider_id.exists' => 'Slider không tồn tại',
            'title.required' => 'Vui lòng nhập tiêu đề',
            'position.required' => 'Vui lòng chọn vị trí',
            'image.required' => 'Vui lòng chọn ảnh',
        ];
    }
}
