<?php

namespace App\Http\Requests\Admin\AccountsRequet;

use Illuminate\Foundation\Http\FormRequest;

class ChangeActiveRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:accounts,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*' => 'Account không tồn tại !'
        ];
    }
}
