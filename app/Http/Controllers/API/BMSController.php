<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BMS\Area;
use App\Models\BMS\Master;
use App\Models\BMS\Realization;
use App\Models\BMS\Report;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BMSController extends Controller
{
    public function areas($buildingId, $serviceId)
    {
        $employeeId = Auth::user()->employee_id;
        $areas = Area::where('building_id', $buildingId)
            ->where('service_id', $serviceId) //616 MEANS = SECURITY
        ->get();
//        $arrTotal = DB::table('bms_masters')
//            ->where('service_id', '616') //616 MEANS = SECURITY
//            ->select('object_id', DB::raw('COUNT(id) as totalActivities'))
//            ->groupBy('object_id')
//            ->pluck('totalActivities', 'object_id');
        $arrTotal = DB::table('bms_objects as t1')
            ->select('t1.area_id', DB::raw('COUNT(t1.id) as totalActivities'))
            ->join('bms_shifts as t2', 't1.area_id', 't2.area_id')
            ->join('bms_masters as t3', function ($join){
                $join->on('t3.object_id', 't1.object_id');
                $join->on('t3.service_id', 't1.service_id');
            })
            ->where('t2.building_id', $buildingId)
            ->where('t2.service_id', $serviceId)
            ->groupBy('t1.area_id')
            ->pluck('totalActivities', 't1.area_id');
        $arrTotalRealization = Realization::where('employee_id', $employeeId)->where('building_id', $buildingId)
            ->where('service_id', $serviceId)
            ->where('control_result', 1)
            ->select('area_id', DB::raw('COUNT(id) as totalRealizations'))
            ->groupBy('area_id')
            ->pluck('totalRealizations', 'area_id');
        foreach($areas as $area){
            $area->totalActivityArea = $arrTotal[$area->id];
            $area->totalRealization = isset($arrTotalRealization[$area->id]) ? $arrTotalRealization[$area->id] : 0;
        }

        if($areas) {
            return response()->json([
                "data" => $areas,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function getActivities($areaCode)
    {
        $employeeId = Auth::user()->employee_id;
        $areaId = Area::where('code', $areaCode)->value('id');
        $activities = DB::table('bms_objects as t1')
            ->select('t1.id', 't1.name', 't1.object_id', 't1.service_id', 't2.id as shiftId', 't2.name as shiftName', 't2.start', 't2.end')
            ->join('bms_shifts as t2', 't1.area_id', 't2.area_id')
            ->where('t2.building_id', DB::raw('2'))
            ->where('t2.service_id', DB::raw('616'))
            ->where('t2.area_id', $areaId)
            ->orderBy('t2.start', 'asc')
            ->orderBy('t1.order', 'asc')
            ->get();
        $results = DB::table('bms_realizations')->where('employee_id', $employeeId)->where('building_id', '2')
            ->where('service_id', '616')
            ->where('area_id', $areaId)
            ->get();
        foreach ($results as $r){
            $arrResult[$r->object_id][$r->shift_id][$r->activity_id] = $r->control_result;
        }
        foreach ($activities as $activity){
            $activity->activities = Master::select('id', 'name')->where('object_id', $activity->object_id)
                ->where('service_id', $activity->service_id)
                ->get();
            foreach ($activity->activities as $r){
                $r->result = isset($arrResult[$activity->id][$activity->shiftId][$r->id]) ? $arrResult[$activity->id][$activity->shiftId][$r->id] : '';
            }
            //CHECK IF THIS AREA CAN ACCESS NOW OR NOT
            $time = Carbon::now();
            list($startHour, $startMinute) = explode(':', $activity->start);
            list($endHour, $endMinute) = explode(':', $activity->end);
            $startShift = Carbon::create($time->year, $time->month, $time->day, $startHour, $startMinute, 0); //set time to 08:00
            $endShift = Carbon::create($time->year, $time->month, $time->day, $endHour, $endMinute, 0); //set time to 18:00
            if($time->between($startShift, $endShift, true)) {
                $activity->access = true;
            } else {
                $activity->access = false;
            }
        }

        if($activities) {
            return response()->json([
                "data" => $activities,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function storeActivities(Request $request)
    {
        //GET EMPLOYEE FROM AUTH LOGIN
        $employeeId = Auth::user()->employee_id;
        //GET AREA ID FROM SELECTED CODE
        $areaId = Area::where('code', $request->areaCode)->value('id');
        foreach ($request->datas as $key => $result){
            //CREATE VARIABLE FROM PASSED KEY
            list($type, $objectId, $shiftId, $activityId) = explode('|', $key);

            //insert realizations
            $datas['realizations'][] =Realization::updateOrCreate(
                [
                'employee_id' => $employeeId,
                'building_id' => '2',
                'service_id' => '616',
                'area_id' => $areaId,
                'object_id' => $objectId,
                'shift_id' => $shiftId,
                'activity_id' => $activityId,
                'control_type' => $type,
                ],[
                'control_result' => $result,
                ]
            );
        }
        if($datas) {
            return response()->json([
                "data" => $datas,
                "message" => "activity record created",
            ], 200);
        }else{
            return response()->json([
                "data" => $datas,
                "message" => "something wrong",
            ], 500);
        }
    }

    public function getDataReportByDate($date, $employeeId)
    {
        $reports = Report::where('employee_id', $employeeId)->where('date', $date)->get();

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
        $reports = Report::find($id);

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
            '/uploads/bms/report/');
        if($request->id){
            $report = Report::find($request->id);
            if($image != null){
                if($report->image)
                    Storage::disk('public')->delete($report->image);
            }
            $report->employee_id = $emp->id;
            $report->building_id = '7';
            $report->area_id = '8';
            $report->service_id = '9';
            $report->date = $request->date;
            $report->description = $request->description;
            $report->location = $request->location;
            $report->image = $image ?? $report->image;
            $report->time = $request->time;
            $report->save();
        }else{
            $report = Report::create([
                'employee_id' => $emp->id,
                'building_id' => '7',
                'area_id' => '8',
                'service_id' => '9',
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
