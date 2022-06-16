<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class MasterPlacementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'leader_id' => 'required',
            'administration_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Field Nama tidak boleh kosong',
            'leader_id.required' => 'Field Atasan tidak boleh kosong',
            'administration_id.required' => 'Field Admin/Tata Usaha tidak boleh kosong',
        ];
    }
}
