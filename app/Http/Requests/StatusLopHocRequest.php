<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusLopHocRequest extends FormRequest
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
