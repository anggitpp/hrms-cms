<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendanceLeave;
use App\Models\ESS\AttendanceLeaveMaster;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LeaveController extends Controller
{
    public function getDataMonthly($employeeId, $month, $year)
    {
        $leaves = AttendanceLeave::where('employee_id', $employeeId)
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->orderBy('start_date', 'asc')
            ->get();

        $types = AttendanceLeaveMaster::where('status', 't')->get();

        foreach ($leaves as $leave){
            //SET TYPE COLLECTION TO LEAVE COLLECTION
            $leave->type = $types->find($leave->type_id);

            //CONVERT START DATE TO CARBON FORMAT
            $startDate = Carbon::parse($leave->start_date);
            //CONVERT END DATE TO CARBON FORMAT
            $endDate = Carbon::parse($leave->end_date);

            //CHECK IF DATE START AND END IS SAME, THEN ONLY NEED 1 DAY
            if($startDate == $endDate) {
                $leave->period = $startDate->translatedFormat('d F');
            }else{
                //CHECK IF TWO DATE SAME MONTH THEN JUST SHOW 1 MONTH WITH TWO DATES
                if($startDate->month == $endDate->month)
                {
                    $leave->period = $startDate->format('d')." - ".$endDate->translatedFormat('d F');
                }
                //ELSE WHICH MEANS DIFFERENT DATE AND DIFFRENET MONTH
                else
                {
                    $leave->period = $startDate->translatedFormat('d M')." - ".$endDate->translatedFormat('d M');
                }
            }
        }

        if($leaves) {
            return response()->json([
                "data" => $leaves,
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
        $emp = Employee::find($request->employee_id);
        $selectedLeave = AttendanceLeave::where('number', $request->number)->first();

        $image = uploadFile(
            $request->file('image'),
            Str::slug($emp->name).'_'.time(),
            '/uploads/ess/leave/');
        if($selectedLeave) {
            if ($image != null) {
                if ($selectedLeave->filename)
                    Storage::disk('public')->delete($selectedLeave->filename);
            }
        }

        $leave = AttendanceLeave::updateOrCreate([
            'number' => $request->number,
        ],[
            'date' => date('Y-m-d'),
            'employee_id' => $request->employee_id,
            'type_id' => $request->type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'quota' => $request->quota,
            'amount' => $request->amount,
            'remaining' => $request->remaining,
            'description' => $request->description,
            'filename' => $image,
            'approved_status' => 'p',
        ]);

        $leave->type = AttendanceLeaveMaster::find($leave->type_id);

        if($leave) {
            return response()->json([
                "data" => $leave,
                "message" => "leave record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function edit($id)
    {
        $leave = AttendanceLeave::find($id);
        $leave->type = AttendanceLeaveMaster::find($leave->type_id);

        if($leave) {
            return response()->json([
                "data" => $leave,
                "message" => "success get leave record",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function destroy($id)
    {
        $leave = AttendanceLeave::find($id);
        Storage::disk('public')->delete($leave->filename);
        $leave->delete();

        if($leave) {
            return response()->json([
                "message" => "success",
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
        $getLastNumber = AttendanceLeave::where(DB::raw('year(created_at)'), date('Y'))
                ->where(DB::raw('month(created_at)'), date('m'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $lastNumber = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/IC/'.date('Y');

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

    public function getMasters()
    {
        $masters = AttendanceLeaveMaster::active()->get();

        if($masters) {
            return response()->json([
                "data" => $masters,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getDetailMaster(Request $request, $id, $startDate, $endDate)
    {
        //GET DATA EMPLOYEE FROM AUTH
        $emp = Employee::find(\Auth::user()->employee_id);

        //GET DATA FROM LEAVE APPLIED BY SELECTED EMPLOYEE AND SELECTED TYPE
        $dataApplied = AttendanceLeave::where('type_id', $id)
            ->where('employee_id', $emp->id);
        if($request->id)
            $dataApplied->where('id', '!=', $request->id);

        $amountApplied = $dataApplied->sum('amount') ?? 0;

        //GET DATA LEAVE FROM SELECTED TYPE
        $leave = AttendanceLeaveMaster::find($id);
        $leaveQuota = $leave->value('quota');

        //CHECK IF GENDER IS NOT ALL THEN CHECK EMPLOYEE GENDER, IF NOT EQUAL MAKE ALL ZERO
        if($leave->gender != 'a' && $leave->gender != $emp->gender)
        {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = 0;
            if($data) {
                return response()->json([
                    "data" => $data,
                    "message" => "success get detail master record",
                ], 200);
            }else{
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }
        }

        //GET MONTH DIFFERENCE FROM NOW AND JOIN DATE
        $diffMonth = Carbon::parse($emp->join_date)->diffInMonths(Carbon::now());

        //CHECK IF WOKRING LIFE REQUIREMENT LEAVE IS LESS THAN WORKING LIFE EMPLOYEE, IF NOT THEN MAKE IT ALL ZERO
        if($leave->working_life >= $diffMonth)
        {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = 0;
            if($data) {
                return response()->json([
                    "data" => $data,
                    "message" => "success get detail master record",
                ], 200);
            }else{
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }
        }

        //CHECK IF LOCATION IS NOT 'SEMUA LOKASI' THEN CHECK IF LOCATION REQUIREMENT IS EQUAL WITH EMPLOYEE LOCATION, IF NOT MAKE IT ALL ZERO
        if($leave->location_id && $leave->location_id != $emp->contract->location_id)
        {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = 0;
            if($data) {
                return response()->json([
                    "data" => $data,
                    "message" => "success get detail master record",
                ], 200);
            }else{
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }
        }

        //GET REMAINING QUOTA FROM QUOTA - AMOUNT APPLIED
        $remaining = $leaveQuota - $amountApplied;

        $data['quota'] = $remaining;
        $data['amount'] = 0;
        $data['remaining'] = $remaining;

        //PARSE DATE TO CARBON FORMAT
        if($startDate && $endDate){
            $formattedStartDate = Carbon::create($startDate);
            $formattedEndDate = Carbon::create($endDate);

            //GET DIFF DAYS THEN + 1, CAUSE SAMEDAY COUNTED 1
            $diffDays = ($formattedStartDate->diffInDays($formattedEndDate)) + 1;

            //GET PERIOD BETWEEN TWO DATES
            $period = CarbonPeriod::create($formattedStartDate, $formattedEndDate);

            // Iterate over the period
            foreach ($period as $date) {
                $arrDateList[] = $date->format('Y-m-d');
            }

            //CHECK IF ANY WEEKEND THEN ++
            $weekend = 0;
            foreach ($arrDateList as $key) {
                $cekDay = date('w', strtotime($key));
                if ($cekDay == 0 || $cekDay == 6) {
                    $weekend++;
                }
            }

            $data['quota'] = $remaining;
            $data['amount'] = $diffDays - $weekend;
            $data['remaining'] = $remaining - $data['amount'];
        }

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success get detail master record",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }
}
