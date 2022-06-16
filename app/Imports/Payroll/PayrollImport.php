<?php

namespace App\Imports\Payroll;

use App\Models\Employee\Employee;
use App\Models\Payroll\PayrollUploadDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayrollImport implements ToModel, WithHeadingRow
{
    public function __construct($id)
    {
        $this->id = $id;
        $this->employees = Employee::select('emp_number', 'id')->pluck('id', 'emp_number')->toArray();

    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $exist = PayrollUploadDetail::where('employee_id', $this->employees[$row['nik']])->where('upload_id', $this->id)->first();

        if($exist){
            $exist->value = $row['nilai'];
            $exist->description = $row['keterangan'];
            $exist->save();

            return null;
        }

        return new PayrollUploadDetail([
            'upload_id' => $this->id,
            'employee_id' => $this->employees[$row['nik']],
            'value' => $row['nilai'],
            'description' => $row['keterangan'],
        ]);
    }

}
