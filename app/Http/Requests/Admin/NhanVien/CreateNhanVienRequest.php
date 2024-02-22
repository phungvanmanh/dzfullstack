<?php

namespace App\Http\Requests\Admin\NhanVien;

use Illuminate\Foundation\Http\FormRequest;

class CreateNhanVienRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'                 =>  'required|email|unique:nhan_viens,email',
            'ho_va_ten'             =>  'required',
            'password'              =>  'required|min:6',
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
            'email.required'              =>  'Email không được để trống!',
            'email.email'                 =>  'Email phải đúng định dạng!',
            'email.unique'                =>  'Email đã tồn tại trong hệ thống!',
            'ho_va_ten.required'          =>  'Họ và tên không được để trống!',
            'password.required'           =>  'Mật khẩu không được để trống!',
            'password.min'                =>  'Mật khẩu phải từ 6 ký tự!',
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
