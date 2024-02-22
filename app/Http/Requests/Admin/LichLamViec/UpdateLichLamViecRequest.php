<?php

namespace App\Http\Requests\Admin\LichLamViec;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLichLamViecRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'    =>  'required|exists:lich_lam_viecs,id',
        ];
    }

    public function messages()
    {
        return [
            'id.*'  =>  'Buổi làm việc không tồn tại',
        ];
    }
}
