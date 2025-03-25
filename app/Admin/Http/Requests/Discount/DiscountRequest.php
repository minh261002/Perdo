<?php

namespace App\Admin\Http\Requests\Discount;

use App\Admin\Http\Requests\BaseRequest;

class DiscountRequest extends BaseRequest
{
    public function methodPost()
    {
        return [
            'code' => 'required|unique:discounts,code',
            'max_usage' => 'nullable',
            'min_order_amount' => 'nullable',
            'type' => 'required',
            'discount_value' => 'nullable',
            'percent_value' => 'nullable',
            'user_id' => 'nullable',
            'date_start' => 'required',
            'date_end' => 'required|after:date_start',
            'apply_for' => 'required',
            'status' => 'required',
            'description' => 'nullable',
            'show_home' => 'nullable',
        ];
    }

    public function methodPut()
    {
        return [
            'id' => 'required|exists:discounts,id',
            'code' => 'required|unique:discounts,code,' . $this->id,
            'max_usage' => 'nullable',
            'min_order_amount' => 'nullable',
            'type' => 'required',
            'discount_value' => 'nullable',
            'percent_value' => 'nullable',
            'user_id' => 'nullable',
            'date_start' => 'required',
            'date_end' => 'required|after:date_start',
            'apply_for' => 'required',
            'status' => 'required',
            'description' => 'nullable',
            'show_home' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Vui lòng nhập mã giảm giá',
            'code.unique' => 'Mã giảm giá đã tồn tại',
            'type.required' => 'Vui lòng chọn loại giảm giá',
            'date_start.required' => 'Vui lòng chọn ngày bắt đầu',
            'date_end.required' => 'Vui lòng chọn ngày kết thúc',
            'date_end.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'status.required' => 'Vui lòng chọn trạng thái',
        ];
    }
}
