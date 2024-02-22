<?php

namespace App\Http\Requests\HocVien\DonXinPhep;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHocVienXinVangRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ly_do_vang'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ly_do_vang.*' => "Lý do vắng không được để trống!"
        ];
    }
}
