<?php

namespace App\Http\Requests\admins;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'hotel_id' => 'required' ,
            'room_type_id' => 'required' ,
            'room_name' => 'required|min:6' ,
            'number_people' => 'required|integer|min:1' ,
            'price' => 'required|numeric|min:1' ,
            'description' => 'required|min:50' ,
        ] ;
    }

    public function messages() {
        return [
            'hotel_id.required' => ':attribute không được trống' ,
            'room_type_id.required' => ':attribute không được trống' ,
            'room_name.required' => ':attribute không được trống' ,
            'room_name.min' => ':attribute ít nhất 6 kí tự' ,
            'number_people.required' => ':attribute không được trống' ,
            'number_people.integer' => ':attribute phải là số nguyên dương' ,
            'number_people.min' => ':attribute phải lớn hơn 0' ,
            'price.required' => ':attribute không được trống' ,
            'price.numeric' => ':attribute phải là số nguyên dương' ,
            'price.min' => ':attribute phải lớn hơn 0' ,
            'description.required' => ':attribute không được trống' ,
            'description.min' => ':attribute ít nhất 50 kí tự' ,
        ] ;
    }

    public function attributes() {
        return [
            'hotel_id' => 'Mã khách sạn' ,
            'room_type_id' => 'Mã loại phòng' ,
            'room_name' => 'Tên phòng' ,
            'number_people' => 'Số lượng người' ,
            'price' => 'Giá phòng' ,
            'description' => 'Mô tả phòng' ,
        ] ;
    }
}
