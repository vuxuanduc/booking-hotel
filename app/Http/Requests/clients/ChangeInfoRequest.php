<?php

namespace App\Http\Requests\clients;

use Illuminate\Foundation\Http\FormRequest;

class ChangeInfoRequest extends FormRequest
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
            'full_name' => 'required' ,
            'phone' => 'required|regex:/^0\d{9,10}$/'
        ];
    }

    public function messages() {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên' ,
            'phone.required' => 'Vui lòng nhập số điện thoại' ,
            'phone.regex' => 'Số điện thoại bắt đầu từ 0 và có 10 hoặc 11 số'
        ] ;
    }
}
