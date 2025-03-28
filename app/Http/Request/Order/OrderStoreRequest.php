<?php

namespace App\Http\Request\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    //     array:5 [▼ // app/Http/Controllers/CheckoutController.php:21
//   "_token" => "0BCCJtsFOwVxEOxDPMIz2aq0r9uagAKCImsNQuf3"
//   "order" => array:11 [▼
//     "name" => "Trần Công Minh"
//     "email" => "minh02@gmail.com"
//     "phone" => null
//     "address" => null
//     "lat" => null
//     "lng" => null
//     "note" => null
//     "discount" => "0"
//     "shipping_fee" => "0"
//     "subtotal" => "880000"
//     "total" => "880000"
//   ]
//   "discount_code" => null
//   "discount_id" => null
//   "transaction" => array:1 [▼
//     "payment_method" => "cash_on_delivery"
//   ]
// ]


    public function rules()
    {
        return [
            'order.name' => ['required'],
            'order.email' => ['required', 'email'],
            'order.phone' => ['required'],
            'address' => ['required'],
            'lat' => ['required',],
            'lng' => ['required',],
            'order.note' => ['nullable'],
            'order.discount' => ['required',],
            'order.shipping_fee' => ['required',],
            'order.subtotal' => ['required',],
            'order.total' => ['required',],
            'discount_id' => ['nullable',],
            'transaction.payment_method' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'order.name.required' => 'Vui lòng nhập họ tên.',
            'order.email.required' => 'Vui lòng nhập email.',
            'order.email.email' => 'Email không đúng định dạng.',
            'order.phone.required' => 'Vui lòng nhập số điện thoại.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'lat.required' => 'Vui lòng chọn vị trí trên bản đồ.',
            'lng.required' => 'Vui lòng chọn vị trí trên bản đồ.',
            'order.discount.required' => 'Vui lòng nhập giá trị giảm giá.',
            'order.shipping_fee.required' => 'Vui lòng nhập phí vận chuyển.',
            'order.subtotal.required' => 'Vui lòng nhập tổng tiền.',
            'order.total.required' => 'Vui lòng nhập tổng tiền.',
            'transaction.payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
        ];
    }
}