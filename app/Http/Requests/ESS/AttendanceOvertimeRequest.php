<?php

namespace App\Http\Requests\ESS;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceOvertimeRequest extends FormRequest
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
            'description' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Field Data Pegawai tidak boleh kosong',
            'description.required' => 'Field Keterangan tidak boleh kosong',
            'start_date.required' => 'Field Tanggal Mulai tidak boleh kosong',
            'start_time.required' => 'Field Jam Mulai tidak boleh kosong',
            'end_time.required' => 'Field Jam Selesai tidak boleh kosong',
        ];
    }
}
