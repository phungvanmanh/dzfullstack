<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaoLichDeCuongRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ma_mon_hoc'        => 'required|between:5,6',
            'loai_mon'          => 'required|numeric|between:1,3',
            'so_buoi_de_cuong'  => 'required|numeric',
        ];
    }
    public function attributes()
    {
        return [
            'ma_mon_hoc'            => 'Mã môn học',
            'loai_mon'              => 'Loại môn học',
            'so_buoi_de_cuong'      => 'Số buổi đề cương'
        ];
    }
    public function messages()
    {
        return [
            'required'      =>':attribute không được bỏ trống',
            'numeric'       =>':attribute phải là một số',
            'between'       =>':attribute phải gồm 5 hoặc 6 ký tự',
        ];
    }
}
