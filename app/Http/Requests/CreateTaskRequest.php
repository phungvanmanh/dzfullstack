<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'id_giao'               => 'required|exists:nhan_viens,id',
            'list_nhan'             => 'required',
            'tieu_de'               => 'required',
            'thoi_gian_nhan'        => 'required|after_or_equal:' . Carbon::today(),
            'deadline'              => 'required|after_or_equal: thoi_gian_nhan',
        ];
    }

    public function attributes()
    {
        return [
            'required'          => ':attribute không được để trống!',
            'exists'            => ':attribute không tồn tại!',
            'after_or_equal'    => ':attribute lớn hơn hoặc bằng!',
        ];
    }

    public function messages()
    {
        return [
            'id_giao'               => 'Người giao',
            'list_nhan'             => 'Người nhận',
            'tieu_de'               => 'Tiêu Đề',
            'thoi_gian_nhan'        => 'Thời Gian Nhận',
            'deadline'              => 'Deadline',
        ];
    }
}
