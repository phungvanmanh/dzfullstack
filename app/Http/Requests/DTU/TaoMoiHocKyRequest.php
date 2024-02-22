<?php

namespace App\Http\Requests\DTU;

use Illuminate\Foundation\Http\FormRequest;

class TaoMoiHocKyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'begin'     => 'required|date',
            'end'       => 'required|date|after_or_equal:begin',
            'year'      => 'required|min:9',
            'ky'        => 'required|between:1,3',
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute không được để trống!',
            'date'              => ':attribute phải là ngày',
            'after_or_equal'    => ':attribute lơn hơn hoặc bằng',
            'min'               => ':attribute phải ít 8 kí tự',
            'between'           => ':attribute chỉ được chọn 1 trong 3 kì',
        ];
    }

    public function attributes()
    {
        return [
            'begin'     => 'Ngày bắt đầu',
            'end'       => 'Ngày kết thúc',
            'year'      => 'Năm Học',
            'ky'        => 'Học Kì',
        ];
    }
}
