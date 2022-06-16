<?php

namespace App\Http\Requests\ESS;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceReimbursementRequest extends FormRequest
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
            'description' => 'required',
            'value' => 'required|min:1|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Field Data Pegawai tidak boleh kosong',
            'category_id.required' => 'Field Kategori Reimbursement tidak boleh kosong',
            'description.required' => 'Field Keterangan tidak boleh kosong',
            'value.not_in' => 'Kolom Nilai tidak boleh kosong / 0',
        ];
    }
}
