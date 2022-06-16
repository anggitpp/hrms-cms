<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceShift;
use App\Models\Employee\Employee;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\MonitoringReport;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MonitoringController extends Controller
{
    public function getListMonitoring()
    {
        $employeeId = Auth::user()->employee_id;

        $employees = DB::table('employees as t1')->join('employee_contracts as t2', function ($join){
            $join->on('t1.id', 't2.employee_id');
            $join->where('t2.status', 't');
        })
            ->join('attendance_shifts as t3', 't2.shift_id', 't3.id')
            ->select('t1.id', 't1.name', 't1.emp_number', 't3.name as namaShift', 't3.start', 't3.end', 't3.break_start', 't3.break_end')
            ->where('t1.id', $employeeId)
            ->first();

        $start = Carbon::parse($employees->start);
        $end = Carbon::parse($employees->end);
        $listHours = collect(CarbonInterval::minutes(60)->toPeriod($start, $end))->map->format('H:i');
        $cekExist = Monitoring::where('employee_id', $employeeId)->where('date', date('Y-m-d'))->get();
        if($cekExist->isEmpty()) {
            foreach ($listHours as $key => $value) {
                if ($value != substr($employees->break_start, 0, 5)) {
                    $startHour = Carbon::parse($value);
                    $endHour = Carbon::parse($value)->addHour();
                    if($startHour != $end) {
                        Monitoring::updateOrCreate([
                            'employee_id' => $employeeId,
                            'date' => date('Y-m-d'),
                            'start' => $startHour->format('H:i'),
                            'end' => $endHour->format('H:i'),
                        ]);
                    }
                }
            }
        }

        $monitorings = Monitoring::where('employee_id', $employeeId)->where('date', date('Y-m-d'))
            ->orderBy('start', 'asc')->get();

        $employees->monitorings = $monitorings;

        if($employees) {
            return response()->json([
                "data" => $employees,
                "message" => "successs",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function update()
    {
        $employeeId = Auth::user()->employee_id;

        $monitoring = Monitoring::where('employee_id', $employeeId)
            ->where('date', date('Y-m-d'))
//            ->where('start', '<=', '15:00')
//            ->where('end', '>=', '15:00')
            ->where('start', '<=',date('H:i'))
            ->where('end', '>=',date('H:i'))
            ->first();

        if($monitoring->actual == null){
            $monitoring->actual = date('H:i');
            $monitoring->save();
            $result = 'saved';
        }else{
            $result = 'exist';
        }
        if($monitoring) {
            return response()->json([
                "message" => $result,
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }


    public function getDataReportByDate($date)
    {
        $employeeId = Auth::user()->employee_id;
        $reports = MonitoringReport::where('employee_id', $employeeId)->where('date', $date)->get();

        if($reports) {
            return response()->json([
                "data" => $reports,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getDataReportById($id)
    {
        $reports = MonitoringReport::find($id);

        if($reports) {
            return response()->json([
                "data" => $reports,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function storeReport(Request $request)
    {
        $emp = Employee::find(Auth::user()->employee_id);
        $image = uploadFile(
            $request->file('image'),
            Str::slug($emp->name).'_'.time(),
            '/uploads/monitoring/report/');
        if($request->id){
            $report = MonitoringReport::find($request->id);
            if($image != null){
                if($report->image)
                    Storage::disk('public')->delete($report->image);
            }
            $report->employee_id = $emp->id;
            $report->date = $request->date;
            $report->description = $request->description;
            $report->location = $request->location;
            $report->image = $image ?? $report->image;
            $report->time = $request->time;
            $report->save();
        }else{
            $report = MonitoringReport::create([
                'employee_id' => $emp->id,
                'date' => $request->date,
                'description' => $request->description,
                'location' => $request->location,
                'image' => $image,
                'time' => $request->time,
            ]);
        }

        if($report) {
            return response()->json([
                "data" => $report,
                "message" => "report record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

}
