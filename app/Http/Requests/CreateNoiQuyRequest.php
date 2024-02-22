<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoiQuyRequest extends FormRequest
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
            'noi_dung' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'noi_dung.*' => 'Nội dung nội quy không được để trống!'
        ];
    }
}
