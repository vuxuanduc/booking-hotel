<?php

namespace App\Http\Requests\admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomTypeAdminRequest extends FormRequest
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
        $room_type_id = $this->route('room_type') ;

        $rules = [
            'room_type_name' => 'required|min:6'
        ];

        if($this->method() === "PUT") {
            $rules['room_type_name'] = [
                'required' ,
                'min:6' ,
                Rule::unique('room_types' , 'room_type_name')->ignore($room_type_id) ,
            ] ;
        }else {
            $rules['room_type_name'] .= '|unique:room_types,room_type_name' ;
        }

        return $rules ;
    }

    public function messages() {
        return [
            'room_type_name.required' => ':attribute không được trống' ,
            'room_type_name.min' => ':attribute phải ít nhất 6 kí tự' ,
            'room_type_name.unique' => ':attribute đã tồn tại' 
        ] ;
    }

    public function attributes(){
        return [
            'room_type_name' => 'Tên loại phòng'
        ] ;
    }
}
