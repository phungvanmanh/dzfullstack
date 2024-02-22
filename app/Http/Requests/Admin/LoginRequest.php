<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "email"     => "required|exists:nhan_viens,email|email",
            "password"  => "required"
        ];
    }

    public function messages()
    {
        return [
            'required'              => ':attribute không được để trống!',
            'exists'                => ':attribute không tồn tại!',
            'email'                 => ':attribute không đúng định dạng!',
        ];
    }

    public function attributes()
    {
        return [
            "email"     => "Email",
            "password"  => "Mật khẩu"
        ];
    }
}
