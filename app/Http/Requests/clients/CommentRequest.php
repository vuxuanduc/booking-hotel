<?php

namespace App\Http\Requests\clients;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'content_comment' => [
                'required' ,
                'min:6' ,
                function ($attribute, $value, $fail) {
                    if(!session()->has('email')) {
                        $fail(__('auth.failed'));
                    }
                },
            ] ,
        ] ;

        return $rules ;
    }

    public function messages() {
        return [
            'content_comment.required' => ':attribute không được để trống' ,
            'content_comment.min' => ':attribute không được ít hơn :min kí tự' ,
            'content_comment' => 'Vui lòng đăng nhập trước khi bình luận' ,
        ] ;
    }

    public function attributes() {
        return [
            'content_comment' => 'Bình luận' ,
        ] ;
    }
}
