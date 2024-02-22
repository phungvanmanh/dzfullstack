<?php

namespace App\Http\Requests\Admin\KhoaHoc;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKhoaHocRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                        => 'required',
            'ten_khoa_hoc'              => 'required|min:6|max:30',
            'mo_ta_khoa'                => 'required',
            'is_open'                   => 'required|boolean',
            'so_buoi_trong_thang'       => 'required|numeric|min:5',
            'hoc_phi_theo_thang'        => 'required|numeric',
            'so_thang_hoc'              => 'required|numeric|min:3|max:5',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                        => 'Không tìm thấy khóa học',
            'ten_khoa_hoc.*'              => 'Tên khóa học phải từ 6 đến 30 ký tự',
            'mo_ta_khoa.*'                => 'Chưa điền mổ tả khóa',
            'is_open.*'                   => 'Tình trạng không được để trống',
            'so_buoi_trong_thang.*'       => 'Số buổi học không được để trống và phải lơn hơn 5',
            'hoc_phi_theo_thang.*'        => 'Họ phí theo tháng không được để trống',
            'so_thang_hoc.*'              => 'Số tháng học phải từ 3 tháng trở lên',
        ];
    }
}
