<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ArchiveContractRequest extends FormRequest
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
            'position_id' => 'required',
            'type_id' => 'required',
            'rank_id' => 'required',
            'location_id' => 'required',
            'start_date' => 'required',        ];
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
            'employee_id.required' => 'The employee field is required',
            'position_id.required' => 'The position field is required',
            'type_id.required' => 'The type field is required',
            'rank_id.required' => 'The rank field is required',
            'location_id.required' => 'The location field is required',
        ];
    }
}
