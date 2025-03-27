<?php

namespace App\Http\Request\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'stock' => 'required',
            'quantity' => 'required',
        ];
    }
}
