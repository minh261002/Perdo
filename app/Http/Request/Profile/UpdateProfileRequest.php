<?php

namespace App\Http\Request\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'nullable',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->guard('web')->id(),
            'phone' => 'required',
            'address' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'birthday' => 'nullable'
        ];
    }
}
