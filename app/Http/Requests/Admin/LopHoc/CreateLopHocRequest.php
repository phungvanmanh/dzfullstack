<?php

namespace App\Http\Requests\Admin\LopHoc;

use Illuminate\Foundation\Http\FormRequest;

class CreateLopHocRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_khoa_hoc'              =>      'required|exists:khoa_hocs,id',
            'id_nhan_vien_day'         =>      'required|exists:nhan_viens,id',
            'ten_lop_hoc'              =>      'required|min:2',
            'ngay_bat_dau_hoc'         =>      'required|date',
            'link_driver_lop_hoc'      =>      'nullable|min:5',
            'link_zalo_lop'            =>      'nullable|min:5',
            'link_facebook_lop'        =>      'nullable|min:5',
            'mo_ta_khoa'               =>      'nullable|min:5',
            'thu_trong_tuan'           =>      'required',
            'gio_bat_dau'              =>      'required',
            'gio_ket_thuc'             =>      'required',
        ];
    }

    public function messages()
    {
        return [
            'id_khoa_hoc.*'              =>      'Khóa học không tồn tại !',
            'id_nhan_vien_day.*'         =>      'Nhân viên không tồn tại',
            'ten_lop_hoc.*'              =>      'Lớp học không được dưới 2 kí tự !',
            'ngay_bat_dau_hoc.*'         =>      'Ngày bắt đầu học không được để trống',
            'link_driver_lop_hoc.*'      =>      'Link driver không được nhỏ hơn 5 kí tự !',
            'link_zalo_lop.*'            =>      'Link zalo không được nhỏ hơn 5 kí tự !',
            'link_facebook_lop.*'        =>      'Link facebook không được nhỏ hơn 5 kí tự !',
            'mo_ta_khoa.*'               =>      'Mô tả lớp không được dưới 5 kí tự !',
            'thu_trong_tuan.*'           =>      'Thứ trong tuần không được để trống !',
            'gio_bat_dau.*'             =>      'Giờ bắt đầu không được để trống!',
            'gio_ket_thuc.*'            =>      'Giờ kết thúc không được để trống!',
        ];
    }
}
