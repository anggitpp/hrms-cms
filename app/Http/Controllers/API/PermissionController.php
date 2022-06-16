<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendancePermission;
use App\Models\Setting\Master;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function getDataMonthly($employeeId, $month, $year)
    {
        $permissions = AttendancePermission::where('employee_id', $employeeId)
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->orderBy('start_date', 'asc')
            ->get();

        $masters = Master::where('category', 'ESSKI')->get();

        //SET LOCALE CARBON TO ID
        Carbon::setLocale('id');
        foreach ($permissions as $permission){
            $permission->category = $masters->find($permission->category_id);

            //CONVERT START DATE TO CARBON FORMAT
            $startDate = Carbon::parse($permission->start_date);
            //CONVERT END DATE TO CARBON FORMAT
            $endDate = Carbon::parse($permission->end_date);

            //CHECK IF DATE START AND END IS SAME, THEN ONLY NEED 1 DAY
            if($startDate == $endDate) {
                $permission->period = $startDate->translatedFormat('d F');
            }else{
                //CHECK IF TWO DATE SAME MONTH THEN JUST SHOW 1 MONTH WITH TWO DATES
                if($startDate->month == $endDate->month)
                {
                    $permission->period = $startDate->format('d')." - ".$endDate->translatedFormat('d F');
                }
                //ELSE WHICH MEANS DIFFERENT DATE AND DIFFRENET MONTH
                else
                {
                    $permission->period = $startDate->translatedFormat('d M')." - ".$endDate->translatedFormat('d M');
                }
            }
        }

        if($permissions) {
            return response()->json([
                "data" => $permissions,
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
        $selectedPermission = AttendancePermission::where('number', $request->number)->first();

        $image = uploadFile(
            $request->file('image'),
            Str::slug($emp->name).'_'.time(),
            '/uploads/ess/permission/');
        if($selectedPermission) {
            if ($image != null) {
                if ($selectedPermission->filename)
                    Storage::disk('public')->delete($selectedPermission->filename);
            }
        }
        $permission = AttendancePermission::updateOrCreate([
            'number' => $request->number,
        ],[
            'date' => date('Y-m-d'),
            'employee_id' => $request->employee_id,
            'category_id' => $request->category_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'filename' => $image,
            'approved_status' => 'p',
        ]);

        $permission->category = Master::find($permission->category_id);

        if($permission) {
            return response()->json([
                "data" => $permission,
                "message" => "permission record created",
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
        $getLastNumber = AttendancePermission::where(DB::raw('year(created_at)'), date('Y'))
                ->where(DB::raw('month(created_at)'), date('m'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $lastNumber = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/IK/'.date('Y');

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
        $permission = AttendancePermission::find($id);
        $permission->category = Master::find($permission->category_id);

        if($permission) {
            return response()->json([
                "data" => $permission,
                "message" => "permission record updated",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function destroy($id)
    {
        $permission = AttendancePermission::find($id)->delete();

        if($permission) {
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
