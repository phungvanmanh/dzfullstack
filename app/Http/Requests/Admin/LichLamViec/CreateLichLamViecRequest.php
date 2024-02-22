<?php

namespace App\Http\Requests\Admin\LichLamViec;

use Illuminate\Foundation\Http\FormRequest;

class CreateLichLamViecRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ngay_lam_viec'     =>  'required',
            'buoi_lam_viec'     =>  'required|numeric|between:0,3',
        ];
    }
}
