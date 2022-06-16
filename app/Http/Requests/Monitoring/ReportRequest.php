<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ReportRequest extends FormRequest
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
            'date' => 'required',
            'time' => 'required',
            'description' => 'required',
            'location' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Kolom Tanggal tidak boleh kosong',
            'time.required' => 'Kolom Waktu tidak boleh kosong',
            'description.required' => 'Kolom Keterangan tidak boleh kosong',
            'location.required' => 'Kolom Lokasi tidak boleh kosong',
        ];
    }
}
