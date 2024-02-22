<?php

namespace App\Http\Requests\Admin\Support;

use Illuminate\Foundation\Http\FormRequest;

class LopDangDayRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_hoc_vien'         =>  'required|exists:hoc_viens,id',
            'danh_sach_teamview'  =>  'required|exists:hoc_viens,danh_sach_teamview',
            'is_dung_teamview'    =>  'required|boolean',
            'noi_nhan_support'    =>  'required',
            'noi_dung_support'    =>  'required',
        ];
    }
    public function messages()
    {
        return [
            'id_hoc_vien.*'       =>  'Học viên không tồn tại!',
            'danh_sach_teamview.*'  =>  'TeamView/UltraView không chính xác!',
            'is_dung_teamview.*'    =>  'Thông Tin Team/Ultra không được để trống!',
            'noi_nhan_support.*'    =>  'Nơi Support không được để trống!',
            'noi_dung_support.*'    =>  'Nội dung không được để trống!',
        ];
    }
}
