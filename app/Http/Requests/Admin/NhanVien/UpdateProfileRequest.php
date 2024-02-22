<?php

namespace App\Http\Requests\Admin\NhanVien;

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
            'id'                    =>  'required|exists:nhan_viens,id',
            'email'                 =>  'required|email|unique:nhan_viens,email,' . $this->id,
            'ho_va_ten'             =>  'required',
            'so_dien_thoai'         =>  'required|digits:10',
            'facebook'              =>  'required',
            'ngay_sinh'             =>  'required|date',
        ];
    }

    public function messages()
    {
        return [
            'email.*'                     =>  'Nhân viên không tồn tại trong hệ thống!',
            'email.required'              =>  'Email không được để trống!',
            'email.email'                 =>  'Email phải đúng định dạng!',
            'email.unique'                =>  'Email đã tồn tại trong hệ thống!',
            'ho_va_ten.required'          =>  'Họ và tên không được để trống!',
            'so_dien_thoai.required'      =>  'Số điện thoại không được để trống!',
            'so_dien_thoai.digits'        =>  'Số điện thoại phải 10 chữ số!',
            'facebook.required'           =>  'Facebook không được để trống!',
            'ngay_sinh.*'                 =>  'Ngày sinh không được để trống!',
        ];
    }
}
