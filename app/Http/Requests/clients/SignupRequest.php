<?php

namespace App\Http\Requests\clients;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
        $rules = [
            'email' => 'required|email|unique:users,email' ,
            'password' => 'required|min:6' ,
            'confirm_password' => 'required|min:6|same:password'
        ] ;

        return $rules ;
    }

    public function messages() {
        return [
            'email.required' => 'Vui lòng nhập email' ,
            'email.email' => 'Email không hợp lệ' ,
            'email.unique' => 'Email đã tồn tại' ,
            'password.required' => 'Vui lòng nhập mật khẩu' ,
            'password.min' => 'Mật khẩu ít nhất 6 kí tự' ,
            'confirm_password.required' => 'Vui lòng nhập lại mật khẩu' ,
            'confirm_password.min' => 'Mật khẩu ít nhất 6 kí tự' ,
            'confirm_password.same' => 'Mật khẩu không khớp' ,
        ] ;
    }
}
