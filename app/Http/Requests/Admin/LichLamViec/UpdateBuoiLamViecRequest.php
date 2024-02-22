<?php

namespace App\Http\Requests\Admin\LichLamViec;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBuoiLamViecRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id'                     =>  'required|exists:lich_lam_viecs,id',
            'danh_gia'               =>  'required|numeric|min:0|max:100',
            'noi_dung_buoi'          =>  'required|min:6|max:200',
            // 'noi_dung_buoi_danh_gia' =>  'required|min:6|max:200',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                      =>  'Buổi làm việc không tồn tại',
            'danh_gia.*'                =>  'Đánh giá từ 0 cho đến 100',
            'noi_dung_buoi.*'           =>  'Nội dung buổi phải từ 6 đến 200 ký tự',
        // 'noi_dung_buoi_danh_gia.*'  =>  'Nội dung đánh giá buổi phải từ 6 đến 200 ký tự',
        ];
    }
}
