<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendanceOvertime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OvertimeController extends Controller
{
    public function getDataMonthly($employeeId, $month, $year)
    {
        $overtimes = AttendanceOvertime::where('employee_id', $employeeId)
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->orderBy('start_date', 'asc')
            ->get();

        if($overtimes) {
            return response()->json([
                "data" => $overtimes,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function store(Request $request)
    {
        //CONDITION IF END TIME MORE THAN START TIME, THEN ADD 1 DAYS TO END DATE
        $startDate = Carbon::parse($request->date);
        $endDate = $request->date;
        if($request->start_time > $request->end_time)
            $endDate = $startDate->addDays(1)->toDateString();

        //SET DATE AND TIME TO GET DIFF TIME
        $startDateTime = Carbon::parse($request->date. " ".$request->start_time);
        $endDateTime = Carbon::parse($endDate. " ".$request->end_time);
        $request->duration = $endDateTime->diff($startDateTime)->format('%H:%I');

        $emp = Employee::find($request->employee_id);
        $selectedOvertime = AttendanceOvertime::where('number', $request->number)->first();

        $image = uploadFile(
            $request->file('image'),
            Str::slug($emp->name).'_'.time(),
            '/uploads/ess/overtime/');
        if($selectedOvertime) {
            if ($image != null) {
                if ($selectedOvertime->filename)
                    Storage::disk('public')->delete($selectedOvertime->filename);
            }
        }

        $overtime = AttendanceOvertime::updateOrCreate([
            'number' => $request->number,
        ],[
            'date' => date('Y-m-d'),
            'employee_id' => $request->employee_id,
            'start_date' => $request->date,
            'end_date' => $endDate,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'description' => $request->description,
            'filename' => $image,
            'approved_status' => 'p'
        ]);

        if($overtime) {
            return response()->json([
                "data" => $overtime,
                "message" => "overtime record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function getLastNumber()
    {
        //GET LAST NUMBER
        $getLastNumber = AttendanceOvertime::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $lastNumber = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/SPL/'.date('Y');

        if($lastNumber) {
            return response()->json([
                "data" => $lastNumber,
                "message" => "success",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function edit($id)
    {
        $overtime = AttendanceOvertime::find($id);

        if($overtime) {
            return response()->json([
                "data" => $overtime,
                "message" => "attendance record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function destroy($id)
    {
        $overtime = AttendanceOvertime::find($id);
        Storage::disk('public')->delete($overtime->filename);
        $overtime->delete();

        if($overtime) {
            return response()->json([
                "message" => "success",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }
}
