<?php

namespace App\Imports\Attendance;

use App\Models\Attendance\Attendance;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Helpers\Helper;

class DailyImport implements ToModel, WithHeadingRow
{

    public function __construct()
    {
        $this->employees = Employee::select('emp_number', 'id')->pluck('id', 'emp_number')->toArray();

        $this->defaultStatus = defaultStatus();

    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']));
        $startDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']));
        $endDate = $row['masuk'] > $row['pulang'] ? $date->addDays(1)->toDateString() : $startDate;

        $exist = Attendance::where('employee_id', $this->employees[$row['nik']])->where('date', substr($startDate, 0, 10))->first();

        if($exist){
            $exist->end_date = substr($endDate, 0, 10);
            $exist->in = $row['masuk'];
            $exist->out = $row['pulang'];
            $exist->duration = $row['durasi'];
            $exist->save();

            return null;
        }

        return new Attendance([
            'employee_id' => $this->employees[$row['nik']],
            'date' => substr($startDate, 0, 10),
            'start_date' => substr($startDate, 0, 10),
            'end_date' => $endDate,
            'in' => $row['masuk'],
            'out' => $row['pulang'],
            'duration' => $row['durasi'],
            'description' => 'import data',
        ]);
    }

}
