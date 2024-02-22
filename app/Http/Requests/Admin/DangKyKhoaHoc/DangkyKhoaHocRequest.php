<?php

namespace App\Http\Requests\Admin\DangKyKhoaHoc;

use Illuminate\Foundation\Http\FormRequest;

class DangkyKhoaHocRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'ho_va_ten'        => 'required|min:6',
           'email'            => 'required|email',
           'so_dien_thoai'    => 'required|digits:10',
           'facebook'         => 'required|url|regex:/http(?:s):\/\/(?:www\.)facebook\.com\/.+/i',
           'mo_ta_trinh_do'   => 'required',
           'id_lop_dang_ky'   => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return[
           'ho_va_ten'        => 'Họ và tên',
           'email'            => 'Email',
           'so_dien_thoai'    => 'Số Điện Thoại',
           'facebook'         => 'Facebook',
           'mo_ta_trinh_do'   => 'Mô Tả Trình Độ',
           'id_lop_dang_ky'   => 'Chọn Khóa Học',
        ];

    }

    public function messages()
    {
        return[
            'required'  => ':attribute không được để trống',
            'min'       => ':attribute ít nhất phải 6 ký tự',
            'email'     => ':attribute không đúng định dạng',
            'digits'    => ':attribute phải là 10 số',
            'regex'     => ':attribute không đúng định dạng',
            'numeric'   => ':attribute phải là số',
        ];
    }

}
