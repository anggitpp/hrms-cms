<?php

namespace App\Http\Requests\ESS;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceLeaveMasterRequest extends FormRequest
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
            'quota' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Field Nama tidak boleh kosong',
            'amount.required' => 'Field Jumlah tidak boleh kosong',
            'start_date.required' => 'Field Tanggal Mulai tidak boleh kosong',
            'end_date.required' => 'Field Tanggal Selesai tidak boleh kosong',
        ];
    }
}
