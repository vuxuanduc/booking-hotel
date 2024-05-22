<?php

namespace App\Http\Requests\clients;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => [
                'required' ,
                'min:6' ,
                function ($attribute, $value, $fail) {
                    $email = session('email') ;
                    $user = User::where('email' , $email)->first() ;
                    if($user && !Hash::check($this->input('old_password') , $user->password)) {
                        $fail(__('auth.failed'));
                    }
                },
            ] , 
            'new_password' => [
                'required' ,
                'min:6'
            ]
        ];
    }

    public function messages() {
        return [
            'old_password.required' => "Vui lòng nhập mật khẩu cũ" ,
            'old_password.min' => "Mật khẩu phải ít nhất 6 kí tự" ,
            'old_password' => "Mật khẩu cũ không đúng" ,
            'new_password.required' => "Vui lòng nhập mật khẩu mới" ,
            'new_password.min' => "Mật khẩu phải ít nhất 6 kí tự" 
        ] ;
    }
}
