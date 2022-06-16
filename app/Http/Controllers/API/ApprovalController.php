<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ESS\AttendanceLeave;
use App\Models\ESS\AttendanceLeaveMaster;
use App\Models\ESS\AttendanceOvertime;
use App\Models\ESS\AttendancePermission;
use App\Models\ESS\AttendanceReimbursement;
use App\Models\Setting\Master;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function getListApproval(){
        $employeeId = Auth::user()->employee_id;
        $filterAccess = DB::table('employee_contracts as t1')
            ->join('employee_master_placements as t2', function ($join) {
                $join->on('t1.placement_id', 't2.id');
                $join->where('t1.status', 't');
            })
            ->where(function ($sql) use ($employeeId) {
                $sql->where('t2.leader_id', $employeeId)
                    ->orWhere('t2.administration_id', $employeeId)
                    ->orWhere('t1.employee_id', $employeeId);
            });
        $overtimeAccess = clone $filterAccess;
        $data['totalOvertime'] = $overtimeAccess->join('attendance_overtimes as t3', 't3.employee_id', 't1.employee_id')
            ->where('t3.approved_status', 'p')
            ->count('t3.id');
        $permissionAccess = clone $filterAccess;
        $data['totalPermission'] = $permissionAccess->join('attendance_permissions as t3', 't3.employee_id', 't1.employee_id')
            ->where('t3.approved_status', 'p')
            ->count('t3.id');
        $leaveAccess = clone $filterAccess;
        $data['totalLeave'] = $leaveAccess->join('attendance_leaves as t3', 't3.employee_id', 't1.employee_id')
            ->where('t3.approved_status', 'p')
            ->count('t3.id');
        $reimbursementAccess = clone $filterAccess;
        $data['totalReimbursement'] = $reimbursementAccess->join('attendance_reimbursements as t3', 't3.employee_id', 't1.employee_id')
            ->where('t3.approved_status', 'p')
            ->count('t3.id');

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getLeaves(){
        $employeeId = Auth::user()->employee_id;
        $data = DB::table('employees as t1')
            ->join('employee_contracts as t2', function ($join) {
                $join->on('t2.employee_id', 't1.id');
                $join->where('t2.status', 't');
            })
            ->join('employee_master_placements as t3','t2.placement_id', 't3.id')
            ->where(function ($sql) use ($employeeId) {
                $sql->where('t3.leader_id', $employeeId)
                    ->orWhere('t3.administration_id', $employeeId);
            })
            ->join('attendance_leaves as t4', 't4.employee_id', 't1.id')
            ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();

        foreach ($data as $leave){
            $leave->type = AttendanceLeaveMaster::find($leave->type_id);
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
//        if($type == 'overtime')
//        {
//            $access = clone $filterAccess;
//            $data = $access->join('attendance_overtimes as t4', 't4.employee_id', 't1.id')
//                ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();
//        }
//        else if($type == 'leave')
//        {
//            $access = clone $filterAccess;
//            $data = $access
//
//
//        }
//        else if($type == 'permission')
//        {
//            $access = clone $filterAccess;
//            $data = $access->join('attendance_permissions as t4', 't4.employee_id', 't1.id')
//                ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();
//
//            foreach ($data as $permission){
//                $permission->category = Master::find($permission->category_id);
//            }
//        }
//        else
//        {
//            $access = clone $filterAccess;
//            $data = $access->join('attendance_reimbursements as t4', 't4.employee_id', 't1.id')
//                ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();
//
//            foreach ($data as $reimbursement){
//                $reimbursement->category = Master::find($reimbursement->category_id);
//            }
//        }

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getLeave($id){
        $data = AttendanceLeave::with('type')->find($id);

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function updateLeave(Request $request){
        $leave = AttendanceLeave::find($request->id);
        $leave->approved_status = $request->approved_status;
        $leave->approved_by = Auth::user()->employee_id;
        $leave->approved_date = date('Y-m-d H:i:s');
        $leave->approved_note = $request->approved_note;
        $leave->save();

        if($leave) {
            return response()->json([
                "data" => $request->approved_status." ".$request->approved_note,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getOvertimes(){
        $employeeId = Auth::user()->employee_id;
        $data = DB::table('employees as t1')
            ->join('employee_contracts as t2', function ($join) {
                $join->on('t2.employee_id', 't1.id');
                $join->where('t2.status', 't');
            })
            ->join('employee_master_placements as t3','t2.placement_id', 't3.id')
            ->where(function ($sql) use ($employeeId) {
                $sql->where('t3.leader_id', $employeeId)
                    ->orWhere('t3.administration_id', $employeeId);
            })
            ->join('attendance_overtimes as t4', 't4.employee_id', 't1.id')
            ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getOvertime($id){
        $data = AttendanceOvertime::find($id);

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function updateOvertime(Request $request){
        $overtime = AttendanceOvertime::find($request->id);
        $overtime->approved_status = $request->approved_status;
        $overtime->approved_by = Auth::user()->employee_id;
        $overtime->approved_date = date('Y-m-d H:i:s');
        $overtime->approved_note = $request->approved_note;
        $overtime->save();

        if($overtime) {
            return response()->json([
                "data" => $request->approved_status." ".$request->approved_note,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getPermissions(){
        $employeeId = Auth::user()->employee_id;
        $data = DB::table('employees as t1')
            ->join('employee_contracts as t2', function ($join) {
                $join->on('t2.employee_id', 't1.id');
                $join->where('t2.status', 't');
            })
            ->join('employee_master_placements as t3','t2.placement_id', 't3.id')
            ->where(function ($sql) use ($employeeId) {
                $sql->where('t3.leader_id', $employeeId)
                    ->orWhere('t3.administration_id', $employeeId);
            })
            ->join('attendance_permissions as t4', 't4.employee_id', 't1.id')
            ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();

        $masters = Master::where('category', 'ESSKI')->get();

        //SET LOCALE CARBON TO ID
        Carbon::setLocale('id');
        foreach ($data as $permission){
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

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getPermission($id){
        $data = AttendancePermission::with('category')->find($id);

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function updatePermission(Request $request){
        $overtime = AttendancePermission::find($request->id);
        $overtime->approved_status = $request->approved_status;
        $overtime->approved_by = Auth::user()->employee_id;
        $overtime->approved_date = date('Y-m-d H:i:s');
        $overtime->approved_note = $request->approved_note;
        $overtime->save();

        if($overtime) {
            return response()->json([
                "data" => $request->approved_status." ".$request->approved_note,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getReimbursements(){
        $employeeId = Auth::user()->employee_id;
        $data = DB::table('employees as t1')
            ->join('employee_contracts as t2', function ($join) {
                $join->on('t2.employee_id', 't1.id');
                $join->where('t2.status', 't');
            })
            ->join('employee_master_placements as t3','t2.placement_id', 't3.id')
            ->where(function ($sql) use ($employeeId) {
                $sql->where('t3.leader_id', $employeeId)
                    ->orWhere('t3.administration_id', $employeeId);
            })
            ->join('attendance_reimbursements as t4', 't4.employee_id', 't1.id')
            ->select('t4.*', 't1.name as empName', 't1.emp_number')->get();

        foreach ($data as $reimbursement){
            $reimbursement->category = Master::find($reimbursement->category_id);
        }

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getReimbursement($id){
        $data = AttendanceReimbursement::with('category')->find($id);

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function updateReimbursement(Request $request){
        $overtime = AttendanceReimbursement::find($request->id);
        $overtime->approved_status = $request->approved_status;
        $overtime->approved_by = Auth::user()->employee_id;
        $overtime->approved_date = date('Y-m-d H:i:s');
        $overtime->approved_note = $request->approved_note;
        $overtime->save();

        if($overtime) {
            return response()->json([
                "data" => $request->approved_status." ".$request->approved_note,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }
}
