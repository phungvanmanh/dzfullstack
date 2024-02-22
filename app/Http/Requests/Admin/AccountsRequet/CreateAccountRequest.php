<?php

namespace App\Http\Requests\Admin\AccountsRequet;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username'  => 'required|unique:accounts,username',
            'is_active' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required'     => 'UserName không được để trống!',
            'is_active.required'    => 'Tình trạng không được để trống!',
            'username.unique'       => 'UserName đã tồn tại!',
        ];
    }
}
