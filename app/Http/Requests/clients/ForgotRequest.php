<?php

namespace App\Http\Requests\clients;

use Illuminate\Foundation\Http\FormRequest;

class ForgotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email' ,
        ];
    }

    public function messages(){
        return [
            'email.required' => 'Vui lòng nhập email' ,
            'email.email' => 'Email không hợp lệ' ,
            'email.exists' => 'Email không chính xác' ,
        ] ;
    }
}
