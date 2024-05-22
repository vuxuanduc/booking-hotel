<?php

namespace App\Http\Requests\admins;


use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StatusRequest extends FormRequest
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
        $status_id = $this->route('status') ;

        $rules = [
            'name_status' => 'required|min:6' ,
        ] ;

        if($this->method() == "PUT") {
            $rules['name_status'] = [
                'required' ,
                'min:6' ,
                Rule::unique('statuses' , 'name_status')->ignore($status_id) ,
            ] ;
        }else {
            $rules['name_status'] .= '|unique:statuses,name_status' ;
        }

        return $rules ;
    }

    public function messages() {
        return [
            'name_status.required' => ':attribute không được để trống' ,
            'name_status.min' => ':attribute tối thiểu 6 kí tự' ,
            'name_status.unique' => ':attribute đã tồn tại' ,
        ] ;
    }

    public function attributes(){
        return [
            'name_status' => "Tên trạng thái" ,
        ] ;
    }
}
