<?php

namespace App\Http\Requests\HocVien;

use Illuminate\Foundation\Http\FormRequest;

class QuenMatKhaumailRequest extends FormRequest
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
            'email'                 => 'required|email|exists:hoc_viens,email',
            'g-recaptcha-response'  => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'email.*'                 =>  'Tài khoản không tồn tại!',
            'g-recaptcha-response.*'  =>  'Vui lòng phải chọn vào recaptcha!',
        ];
    }
}
