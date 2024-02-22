<?php

namespace App\Http\Requests\Admin\BuoiHoc;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiBuoiHocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'gio_bat_dau'       =>  'required|date',
            'gio_ket_thuc'      =>  'required|date',
            'id_nhan_vien_day'  =>  'required|exists:nhan_viens,id',
            'is_bai_tap'        =>  'required|between:0,1',
            'id_lop_hoc'        =>  'required|exists:lop_hocs,id',
        ];
    }

    public function attributes()
    {
        return [
            'gio_bat_dau'       =>  'Giờ bắt đầu',
            'gio_ket_thuc'      =>  'Giờ kết thúc',
            'id_nhan_vien_day'  =>  'Giáo viên',
            'is_bai_tap'        =>  'Bài tập',
            'id_lop_hoc'        =>  'Lớp học',
        ];
    }

    public function messages()
    {
        return [
            'required'          =>  ':attribute không được để trống',
            'date'              =>  ':attribute phải là định dạng ngày giờ',
            'exists'            =>  ':attribute không tồn tại',
            'between'           =>  ':attribute chỉ được chọn KHÔNG hoặc CÓ',
        ];
    }
}
