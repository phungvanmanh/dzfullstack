<?php

namespace App\Http\Requests\Admin\HocVienLopHoc;

use Illuminate\Foundation\Http\FormRequest;

class HocVienLopHocRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }



    public function rules()
    {
    return [
            'id_hoc_vien'    =>  'required|exists:hoc_viens,id',
            'id_lop_hoc'    =>  'required|exists:lop_hocs,id'
        ];
    }
    public function messages()
    {
        return [
            'id_hoc_vien.*'     =>  'Học viên không tồn tại trong hệ thống!',
            'id_lop_hoc.*'     =>  'Lớp học không tồn tại trong hệ thống!',
        ];
    }
}
