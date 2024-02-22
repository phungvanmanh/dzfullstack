<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchKeyWordRequest extends FormRequest
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
            'begin' => 'required|date',
            'end'   => 'required|date|after_or_equal:begin'
        ];
    }

    public function messages()
    {
        return [
            "begin.*"   => "Ngày bắt đầu không đúng định dạng!",
            "end.*"     => "Ngày kết thúc không đúng định dạng!",
        ];
    }
}
