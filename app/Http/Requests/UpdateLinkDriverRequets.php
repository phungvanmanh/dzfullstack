<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLinkDriverRequets extends FormRequest
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
            'id'       => 'exists:link_drivers,id',
            'ten_link' => 'required',
            'link'     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.*'       => 'Link Chức năng này không tồn tại!',
            'ten_link.*' => 'Tên Chức Năng không được để trống!',
            'link.*'     => 'Link không được để trống!',
        ];
    }
}
