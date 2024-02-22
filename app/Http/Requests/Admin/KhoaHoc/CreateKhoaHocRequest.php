<?php

namespace App\Http\Requests\Admin\KhoaHoc;

use Illuminate\Foundation\Http\FormRequest;

class CreateKhoaHocRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ten_khoa_hoc'              => 'required|min:6|max:30',
            'mo_ta_khoa'                => 'required|min:6',
            'is_open'                   => 'required|boolean',
            'so_buoi_trong_thang'       => 'required|numeric|min:5',
            'hoc_phi_theo_thang'        => 'required|numeric',
            'so_thang_hoc'              => 'required|numeric|min:3|max:5',
        ];
    }

    public function messages()
    {
        return [
            'ten_khoa_hoc.*'              => 'Tên khóa học phải từ 6 đến 30 ký tự',
            'mo_ta_khoa.*'                => 'Mô tả khóa khọc phải từ 6 đến 200 ký tự',
            'is_open.*'                   => 'Tình trạng không được để trống',
            'so_buoi_trong_thang.*'       => 'Số buổi học không được để trống và phải lơn hơn 5',
            'hoc_phi_theo_thang.*'        => 'Họ phí theo tháng không được để trống',
            'so_thang_hoc.*'              => 'Số tháng học phải từ 3 tháng trở lên',
        ];
    }
}
