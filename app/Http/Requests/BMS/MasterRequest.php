<?php

namespace App\Http\Requests\BMS;

use Illuminate\Foundation\Http\FormRequest;

class MasterRequest extends FormRequest
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
            'object_id' => 'required',
            'target_id' => 'required',
            'name' => 'required',
            'interval_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama harus diisi',
            'object_id.required' => 'Kolom Obyek harus diisi',
            'target_id.required' => 'Kolom Sub Obyek harus diisi',
            'interval_id.required' => 'Kolom Interval harus diisi',
        ];
    }
}
