<?php

namespace App\Http\Requests\BMS;

use Illuminate\Foundation\Http\FormRequest;

class TargetRequest extends FormRequest
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
            'service_id' => 'required',
            'object_id' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'service_id.required' => 'Kolom Layanan tidak boleh kosong',
            'object_id.required' => 'Kolom Obyek tidak boleh kosong',
            'name.required' => 'Kolom Nama tidak boleh kosong',
        ];
    }
}
