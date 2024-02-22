<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailUserMBRequest extends FormRequest
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
            'id'            => 'required|exists:user_m_b_s,id'
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute không được để trống!',
            'exists'            => ':attribute không tồn tại!'
        ];
    }

    public function attributes()
    {
        return [
            'id'       => 'Tài khoản MB'
        ];
    }
}
