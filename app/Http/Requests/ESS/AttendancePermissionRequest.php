<?php

namespace App\Http\Requests\ESS;

use Illuminate\Foundation\Http\FormRequest;

class AttendancePermissionRequest extends FormRequest
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
            'employee_id' => 'required',
            'category_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
         ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Field Data Pegawai tidak boleh kosong',
            'category_id.required' => 'Field Tipe Cuti tidak boleh kosong',
            'start_date.required' => 'Field Tanggal Mulai tidak boleh kosong',
            'end_date.required' => 'Field Tanggal Selesai tidak boleh kosong',
        ];
    }
}
