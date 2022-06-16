<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\Attendance\DailyReport;
use App\Http\Controllers\Controller;
use App\Imports\Attendance\DailyImport;
use App\Models\Attendance\Attendance;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filterDate'] = $request->get('filterDate') ? resetDate($request->get('filterDate')) : date('Y-m-d');

        //GET DATA ATTENDANCE
        $sql = DB::table('attendances as t1')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->select('t1.date', 't1.in', 't1.out', 't1.duration', 't2.id', 't2.name', 't2.emp_number', 't4.name as shiftName', 't4.start', 't4.end', 't4.tolerance')
            ->join('employee_contracts as t3',  function ($join){
                $join->on('t2.id', 't3.employee_id');
                $join->on('t3.status', DB::raw('"t"'));
            })
            ->join('attendance_shifts as t4', 't3.shift_id', 't4.id')
            ->where('t1.date', $data['filterDate']);
        //GET FILTER
        $data['filter'] = $request->get('filter');
        //SET FILTER SEARCH WHEN NOT EMPTY
        if (!empty($data['filter']))
            $sql->where('t2.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where

        $attendances = $sql->paginate($this->defaultPagination($request));
        foreach ($attendances as $daily){
            //SET DATE AND TIME TO GET DIFF TIME
            $attStartTime = Carbon::parse($daily->date. " ".$daily->in);
            $shiftStartTime = Carbon::parse($daily->date. " ".$daily->start)->addMinute($daily->tolerance);

            //GET DIFF IN MINUTES THEN APPLY IN DESCRIPTION
            $daily->description = $attStartTime > $shiftStartTime ? 'Terlambat '. $attStartTime->diffInMinutes($shiftStartTime).' Menit' : '';
        }
        $data['attendances'] = $attendances;

        return view('attendances.dailies.index', $data);
    }

    public function import()
    {
        return view('attendances.dailies.import');
    }

    /**
     * Import data from excel
     */
    public function importData(Request $request)
    {
        Excel::import(new DailyImport(), $request->file('filename'));

        return response()->json([
            'success'=>'Absen selesai di import',
            'url'=> route('attendances.dailies.index')
        ]);
    }

    /**
     * Export data
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        return Excel::download(new DailyReport([
            'filter' => $request->get('filter'),
            'filterDate' => $request->get('filterDate'),
        ]), 'Laporan Durasi Kehadiran.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
