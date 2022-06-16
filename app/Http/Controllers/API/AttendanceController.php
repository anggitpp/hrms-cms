<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\AttendanceRoster;
use App\Models\Attendance\AttendanceShift;
use App\Models\Employee\EmployeeContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function inOut(Request $request)
    {
        if($request->end_date) {
            $startTime = $request->start_date.' '.$request->in;
            $endTime = $request->end_date.' '.$request->out;

            $carbonStart = Carbon::parse($startTime);
            $carbonEnd = Carbon::parse($endTime);

            $request->duration = $carbonEnd->diff($carbonStart)->format('%H:%I');
        }
        $attendance = Attendance::updateOrCreate([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'start_date' => $request->start_date,
        ],[
            'end_date' => $request->end_date,
            'in' => $request->in,
            'out' => $request->out,
            'duration' => $request->duration,
        ]);

        if($attendance) {
            return response()->json([
                "data" => $attendance,
                "message" => "attendance record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function getData($employeeId, $date)
    {
        $convertedDate = Carbon::parse($date);
        $yesterday = $convertedDate->addDay(-1)->toDateString();

        //GET DEFAULT SHIFT EMPLOYEE
        $shiftEmployee = EmployeeContract::where('employee_id', $employeeId)->active()->first()->shift_id;
        $defaultShift = AttendanceShift::find($shiftEmployee);

        //GET ROSTER YESTERDAY
        $checkRosterYesterday = AttendanceRoster::where('employee_id', $employeeId)->where('date', $yesterday)->first();
        //IF EXIST THEN GET SHIFT FROM SELECTED ROSTER
        if($checkRosterYesterday)
        {
            $getShiftYesterday = AttendanceShift::find($checkRosterYesterday->shift_id);
        }
        //IF NOT, GET DEFAULT SHIFT
        else
        {
            $getShiftYesterday = $defaultShift;
        }

        $attendances = Attendance::where('employee_id', $employeeId)->where('date', $date)->first();
        if($attendances)
            $attendances->nightShift = $getShiftYesterday->night_shift;

        //IF YESTERDAY SHIFT IS NIGHT SHIFT, THEN GET DATA YESTERDAY
        if($getShiftYesterday->night_shift == 't' && !$attendances) {
            $attendances = Attendance::where('date', $yesterday)->where('employee_id', $employeeId)->first();
            $attendances->nightShift = 't';

            $convertedDateTimeYesterday = Carbon::parse($date . " " . $getShiftYesterday->end);
            $getMaxOut = $convertedDateTimeYesterday->addHour(3)->format('H:i:s');

            //IF MAX OUT IS LESS THAN CURRENT TIME, THEN OUT IS EXPIRED
            if($getMaxOut < Carbon::now()->format('H:i:s')){
                $attendances = null;
            }
        }

        if($attendances) {
            return response()->json([
                "data" => $attendances,
                "message" => "congrats, you accessed this function",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getDataMonthly($employeeId, $month, $year)
    {
        $attendances = DB::table('attendances as t1')
            ->select( 't1.id', 't1.employee_id', 't1.date', 't1.start_date', 't1.end_date', 't1.in', 't1.out', 't1.duration', 't3.start', 't3.end', 't3.tolerance')
            ->join('employee_contracts as t2',  function ($join){
                $join->on('t1.employee_id', 't2.employee_id');
                $join->on('t2.status', DB::raw('"t"'));
            })
            ->join('attendance_shifts as t3', 't2.shift_id', 't3.id')
            ->where('t1.employee_id', $employeeId)
            ->whereMonth('t1.date', $month)->whereYear('t1.date', $year)
            ->get();

        foreach ($attendances as $daily){
            //SET DATE AND TIME TO GET DIFF TIME
            $attStartTime = Carbon::parse($daily->date. " ".$daily->in);
            $shiftStartTime = Carbon::parse($daily->date. " ".$daily->start)->addMinute($daily->tolerance);

            //GET DIFF IN MINUTES THEN APPLY IN DESCRIPTION
            $daily->description = $attStartTime > $shiftStartTime ? 'Terlambat '. $attStartTime->diffInMinutes($shiftStartTime).' Menit' : '';
        }

        if($attendances) {
            return response()->json([
                "data" => $attendances,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }
}
