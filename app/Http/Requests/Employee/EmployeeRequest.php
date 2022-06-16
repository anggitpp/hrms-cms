<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
//use Toastr

class EmployeeRequest extends FormRequest
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
            'emp_number' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'identity_number' => 'required|digits:16',
            'status_id' => 'required',
            'join_date' => 'required',
            'position_id' => 'required',
            'type_id' => 'required',
            'rank_id' => 'required',
            'location_id' => 'required',
            'placement_id' => 'required',
            'start_date' => 'required',
            'religion_id' => 'required',
//            'payroll_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'emp_number.required' => 'Kolom NIK tidak boleh kosong',
            'birth_place.required' => 'Kolom Tempat Lahir tidak boleh kosong',
            'birth_place.required' => 'Kolom Tanggal Lahir tidak boleh kosong',
            'identity_number.required' => 'Kolom No. KTP tidak boleh kosong',
            'identity_number.digits' => 'Kolom No. KTP tidak boleh kurang dari 16',
            'status_id.required' => 'Kolom Status Pegawai tidak boleh kosong',
            'religion_id.required' => 'Kolom Agama tidak boleh kosong',
            'join_date.required' => 'Kolom Tanggal Masuk tidak boleh kosong',
            'position_id.required' => 'Kolom Posisi pada tab Posisi tidak boleh kosong',
            'type_id.required' => 'Kolom Tipe Pegawai pada tab Posisi tidak boleh kosong',
            'rank_id.required' => 'Kolom Pangkat pada tab Posisi tidak boleh kosong',
            'location_id.required' => 'Kolom Lokasi kerja pada tab Posisi tidak boleh kosong',
            'placement_id.required' => 'Kolom Penempatan pada tab Posisi tidak boleh kosong',
            'start_date.required' => 'Kolom Tanggal Mulai pada tab Posisi tidak boleh kosong',
//            'payroll_id.required' => 'Kolom Jenis Payroll pada tab Payroll tidak boleh kosong',
        ];
    }
}
