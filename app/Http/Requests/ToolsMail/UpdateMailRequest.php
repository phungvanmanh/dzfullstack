<?php

namespace App\Http\Requests\ToolsMail;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'full_name'             => 'required',
            'email'                 => 'required|email',
            'email_khoi_phuc'                 => 'required|email',
            'password'              => 'required',
            // 'dob'                   => 'required',
            // 'phone'                 => 'required|digits:10',
            // 'sex'                   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required'              => ':attribute không được để trống!',
            'digits'                => ':attribute không đúng!',
            'email'                 => ':attribute không đúng định dạng!',
        ];
    }

    public function attributes()
    {
        return [
            'full_name'             => 'Họ và tên',
            'email'                 => 'Email',
            'email_khoi_phuc'       => 'Email khôi phục',
            'password'              => 'Mật Khẩu',
            // 'dob'                   => 'Ngày Tháng Năm sinh',
            // 'phone'                 => 'Số Điên Thoại',
            // 'sex'                   => 'Giới Tính',
        ];
    }
}
