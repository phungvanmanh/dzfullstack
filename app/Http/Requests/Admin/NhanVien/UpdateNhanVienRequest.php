<?php

namespace App\Http\Requests\Admin\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                    =>  'required|exists:nhan_viens,id',
            'email'                 =>  'required|email|unique:nhan_viens,email,'. $this->id,
            'ho_va_ten'             =>  'required',
            'so_dien_thoai'         =>  'required|digits:10',
            'facebook'              =>  'required',
            'ngay_sinh'             =>  'required|date',
            'ngay_bat_dau_lam'      =>  'required|date',
            'git_account'           =>  'nullable|regex:/^@[^@]*$/',
            'ten_goi_nho'           =>  'required',

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
            'ngay_bat_dau_lam.*'          =>  'Ngày bắt đầu làm không được để trống!',
            'git_account.*'               =>  'Tài khoản git bắt buộc phải có @!',
            'ten_goi_nho.*'               =>  'Tên gợi nhớ không được để trống!',

        ];
    }
}
