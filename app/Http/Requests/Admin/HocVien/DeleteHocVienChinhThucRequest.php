<?php

namespace App\Http\Requests\Admin\HocVien;

use Illuminate\Foundation\Http\FormRequest;

class DeleteHocVienChinhThucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id'    =>  'required|exists:hoc_viens,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*'    =>  'Học viên không tồn tại'
        ];
    }
}
