<?php

namespace App\Http\Requests\Admin\KhoaHoc;

use Illuminate\Foundation\Http\FormRequest;

class StatusKhoaHocRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'    =>  'required|exists:khoa_hocs,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*'    =>  'Khóa học không tồn tại'
        ];
    }
}
