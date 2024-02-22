<?php

namespace App\Http\Requests\Admin\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                    =>  'required|exists:nhan_viens,id',
            'password'              =>  'required|min:6',
            're_password'           =>  'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password.required'           =>  'Mật khẩu không được để trống!',
            'password.min'                =>  'Mật khẩu phải từ 6 ký tự!',
            're_password.required'        =>  'Mật khẩu nhập lại không được để trống!',
            're_password.same'            =>  'Mật khẩu nhập lại không chính xác',
        ];
    }
}
