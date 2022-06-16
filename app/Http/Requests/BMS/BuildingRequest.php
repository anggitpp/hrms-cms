<?php

namespace App\Http\Requests\BMS;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
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
            'region_id' => 'required',
            'type_id' => 'required',
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama harus diisi',
            'region_id.required' => 'Kolom Wilayah harus diisi',
            'type_id.required' => 'Kolom Tipe harus diisi',
            'code.required' => 'Kolom Kode harus diisi',
        ];
    }
}
