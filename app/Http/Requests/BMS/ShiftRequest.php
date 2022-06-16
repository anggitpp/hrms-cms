<?php

namespace App\Http\Requests\BMS;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ShiftRequest extends FormRequest
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
            'code' => 'required',
            'start' => 'required',
            'end' => 'required',
            'interval_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            throw new HttpResponseException(
                response()->json(['errors' => $errors], 200)
            );
        }

        parent::failedValidation($validator);
    }

    public function messages()
    {
        return [
            'name.required' => 'Field Nama harus diisi',
            'code.required' => 'Field Kode harus diisi',
            'start.required' => 'Field Mulai harus diisi',
            'end.required' => 'Field Selesai harus diisi',
            'interval_id.required' => 'Field Interval harus diisi',
        ];
    }
}
