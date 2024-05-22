<?php

namespace App\Http\Requests\clients;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
            'email' => [
                'required' ,
                'email' ,
                'exists:users,email' ,
                function ($attribute, $value, $fail) {
                    $email = $this->input('email') ;
                    $user = User::where('email' , $email)->first() ;
                    if($user && Hash::check($this->input('password') , $user->password) && $user->status == 2) {
                        $fail(__('auth.failed'));
                    }
                },
            ],
            'password' => [
                'required',
                'min:6',
                function ($attribute, $value, $fail) {
                    $email = $this->input('email') ;
                    $user = User::where('email' , $email)->first() ;
                    if($user && !Hash::check($this->input('password') , $user->password)) {
                        $fail(__('auth.failed'));
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được trống',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không chính xác',
            'email' => 'Tài khoản đã bị khóa',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu ít nhất 6 kí tự',
            'password' => 'Mật khẩu không chính xác',
        ];
    }
}
