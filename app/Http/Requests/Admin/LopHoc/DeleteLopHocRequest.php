<?php

namespace App\Http\Requests\Admin\LopHoc;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLopHocRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id'        =>      'exists:lop_hocs,id',
        ];
    }
}
