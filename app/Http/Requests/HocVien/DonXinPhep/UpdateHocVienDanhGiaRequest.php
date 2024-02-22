<?php

namespace App\Http\Requests\HocVien\DonXinPhep;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHocVienDanhGiaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'hoc_vien_danh_gia_buoi_hoc' => 'required|numeric|min:0|max:100',
            'noi_dung_danh_gia'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hoc_vien_danh_gia_buoi_hoc.*' => 'Điểm đánh giá từ 0 đến 100!',
            'noi_dung_danh_gia'            => 'Nội dung đánh giá chưa điền!',

        ];
    }
}
