<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLinkDriverRequets extends FormRequest
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
            'ten_link' => 'required',
            'link'     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'ten_link.*' => 'Tên Chức Năng không được để trống!',
            'link.*'     => 'Link không được để trống!',
        ];
    }
}
