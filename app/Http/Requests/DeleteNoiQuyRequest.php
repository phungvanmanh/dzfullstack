<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteNoiQuyRequest extends FormRequest
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
            'id'  => 'required|exists:noi_quies,id'
        ];
    }

    public function messages()
    {
        return [
            'id.*' => 'Nội quy không tồn tại!'
        ];
    }
}
