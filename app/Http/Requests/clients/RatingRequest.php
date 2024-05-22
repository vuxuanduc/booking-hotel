<?php

namespace App\Http\Requests\clients;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            'rating' => 'required|integer|between:1,5' ,
            'content_rating' => 'required|min:6' ,
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Vui lòng chọn số sao' ,
            'rating.integer' => 'Điểm phải là số nguyên' ,
            'rating.between' => 'Điểm trong khoảng từ 1 đến 5' ,
            'content_rating.required' => 'Vui lòng nhập đánh giá' ,
            'content_rating.min' => 'Đánh giá ít nhất 6 kí tự' ,
        ] ;
    }
}
