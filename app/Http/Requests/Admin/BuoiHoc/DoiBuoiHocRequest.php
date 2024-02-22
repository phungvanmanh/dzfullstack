<?php

namespace App\Http\Requests\Admin\BuoiHoc;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DoiBuoiHocRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_buoi_doi'               => 'required|exists:buoi_hocs,id',
            // 'ngay_bat_dau_di_hoc_lai'   => 'required|date|after:' . Carbon::today(),
            'ngay_bat_dau_di_hoc_lai'   => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'id_buoi_doi'                =>  'Buổi học',
            'ngay_bat_dau_di_hoc_lai'    =>  'Ngày học lại',
        ];
    }

    public function messages()
    {
        return [
            'required'          =>  ':attribute không được để trống',
            'date'              =>  ':attribute phải là định dạng ngày giờ',
            'after'             =>  ':attribute phải lớn hơn hôm nay',
        ];
    }
}
