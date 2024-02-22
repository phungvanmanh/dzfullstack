<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserMBRequest extends FormRequest
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
            'user_mb'       => 'required|unique:user_m_b_s,user_mb'
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute không được để trống!',
            'unique'            => ':attribute đã tồn tại!'
        ];
    }

    public function attributes()
    {
        return [
            'user_mb'       => 'Tài khoản MB'
        ];
    }
}
