<?php

namespace App\Http\Requests\DTU;

use Illuminate\Foundation\Http\FormRequest;

class DeleteHocKyRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'required'          => ':attribute không được để trống!',
            'exists'            => ':attribute không tồn tại'
        ];
    }

    public function attributes()
    {
        return [
            'id'        => 'Học Kì',
        ];
    }
}
