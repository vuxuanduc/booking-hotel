<?php

namespace App\Http\Requests\admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAdminRequest extends FormRequest
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
        $userId = $this->route('user') ;

        $rules = [
            'email' => 'required|email' ,
            'password' => 'required|min:6' ,
            'full_name' => 'required' ,
            'phone' => 'required|regex:/^0\d{9,10}$/'
        ] ;

        if($this->method() === "PUT") {
            $rules['email'] = [
                'required' ,
                'email' ,
                Rule::unique('users' , 'email')->ignore($userId) 
            ] ;
        }else {
            $rules['email'] .= '|unique:users,email' ;
        }

        return $rules ;
    }

    public function messages() {
        return [
            'email.required' => ':attribute không được để trống' ,
            'email.email' => ':attribute không hợp lệ' ,
            'email.unique' => ':attribute đã tồn tại' ,
            'password.required' => ':attribute không được để trống' ,
            'password.min' => ':attribute ít nhất 6 kí tự' ,
            'full_name.required' => ':attribute không được để trống' ,
            'phone.required' => ':attribute không được để trống' ,
            'phone.regex' => ':attribute bắt đầu là 0 và có 10 hoặc 11 số' ,
        ] ;
    }

    public function attributes() {
        return [
            'email' => 'Email' ,
            'password' => 'Mật khẩu' ,
            'full_name' => 'Họ và tên' ,
            'phone' => 'Số điện thoại' ,
        ] ;
    }
}
