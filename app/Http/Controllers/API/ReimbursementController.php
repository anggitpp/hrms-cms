<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendanceReimbursement;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReimbursementController extends Controller
{
    public function getDataMonthly($month, $year)
    {
        $employeeId = Auth::user()->employee_id;
        $reimbursements = AttendanceReimbursement::with('category')->where('employee_id', $employeeId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get();

        if($reimbursements) {
            return response()->json([
                "data" => $reimbursements,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getLastNumber()
    {
        //GET LAST NUMBER
        $getLastNumber = AttendanceReimbursement::where(DB::raw('year(created_at)'), date('Y'))
                ->where(DB::raw('month(created_at)'), date('m'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $lastNumber = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/RM/'.date('Y');

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

    public function store(Request $request)
    {
        $emp = Employee::find($request->employee_id);
        $selectedReimbursement = AttendanceReimbursement::where('number', $request->number)->first();

        $image = uploadFile(
            $request->file('image'),
            Str::slug($emp->name).'_'.time(),
            '/uploads/ess/reimbursement/');
        if($selectedReimbursement) {
            if ($image != null) {
                if ($selectedReimbursement->filename)
                    Storage::disk('public')->delete($selectedReimbursement->filename);
            }
        }
        $reimbursement = AttendanceReimbursement::updateOrCreate([
            'number' => $request->number,
        ],[
            'date' => $request->date,
            'employee_id' => $request->employee_id,
            'category_id' => $request->category_id,
            'value' => $request->value,
            'description' => $request->description,
            'filename' => $image,
            'approved_status' => 'p',
        ]);

        $reimbursement->category = Master::find($reimbursement->category_id);

        if($reimbursement) {
            return response()->json([
                "data" => $reimbursement,
                "message" => "reimbursement record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function edit($id)
    {
        $reimbursement = AttendanceReimbursement::find($id);
        $reimbursement->category = Master::find($reimbursement->category_id);

        if($reimbursement) {
            return response()->json([
                "data" => $reimbursement,
                "message" => "reimbursement record updated",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function destroy($id)
    {
        $reimbursement = AttendanceReimbursement::find($id);
        Storage::disk('public')->delete($reimbursement->filename);
        $reimbursement->delete();


        if($reimbursement) {
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
