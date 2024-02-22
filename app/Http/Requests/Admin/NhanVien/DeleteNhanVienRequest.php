<?php

namespace App\Http\Requests\Admin\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class DeleteNhanVienRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id'    =>  'required|exists:nhan_viens,id'
        ];
    }
    public function messages()
    {
        return [
            'id.*'     =>  'Nhân viên không tồn tại trong hệ thống!',
        ];
    }
}
