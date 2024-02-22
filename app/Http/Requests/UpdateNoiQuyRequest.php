<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoiQuyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'        => 'required|exists:noi_quies,id',
            'noi_dung'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.*'          => 'Nội quy không tồn tại!',
            'noi_dung.*'    => 'Nội dung nội quy không được để trống!'
        ];
    }
}
