<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatAIRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'message'   =>  'required|min:10',
        ];
    }

    public function messages()
    {
        return [
            'message.*' => 'Câu hỏi phải trên 10 ký tự!',
        ];
    }
}
