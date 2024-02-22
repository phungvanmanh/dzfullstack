<?php

namespace App\Http\Requests\DTU;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHocKyRequest extends FormRequest
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

    public function rules()
    {
        return [
            'id'        => 'required|exists:infos,id',
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
            'exists'            => ':attribute không tồn tại'
        ];
    }

    public function attributes()
    {
        return [
            'id'        => 'Học Kì',
            'begin'     => 'Ngày bắt đầu',
            'end'       => 'Ngày kết thúc',
            'year'      => 'Năm Học',
            'ky'        => 'Học Kì',
        ];
    }
}
