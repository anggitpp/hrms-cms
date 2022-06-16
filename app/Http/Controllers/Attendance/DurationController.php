<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\Attendance\DurationReport;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //SET ALL DEFAULT FILTER
        $data['filterMonth'] = $request->get('filterMonth') ?? date('m');
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $data['filter'] = $request->get('filter') ?? '';

        //GET TOTAL DAYS IN MONTH
        $data['totalDays'] = cal_days_in_month(CAL_GREGORIAN, $data['filterMonth'], $data['filterYear']);

        //GET QUERY EMPLOYEE ACTIVE
        $sql = Employee::query()->active()->select('id','name', 'emp_number');

        //GET LIST ATTENDANCE IN SELECTED MONTH AND YEAR
        $attendances = Attendance::select('employee_id', DB::raw('day(start_date) as day'), 'duration')
            ->whereMonth('date', $data['filterMonth'])
            ->whereYear('date', $data['filterYear'])
            ->get();

        //MAKE ARRAY FROM COLLECTION
        foreach ($attendances as $key => $value)
        {
            $data['absenDatas'][$value->employee_id][$value->day] = $value->duration;
        }

        if(!empty($request->get('filter')))
            $sql->where('name', 'like', '%' . $data['filter'] . '%')->orWhere('emp_number', 'like', '%' . $data['filter'] . '%');

        $data['employees'] = $sql->paginate($this->defaultPagination($request));

        return view('attendances.durations.index', $data);
    }

    /**
     * Export data
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        return Excel::download(new DurationReport([
            'filter' => $request->get('filter'),
            'filterMonth' => $request->get('filterMonth'),
            'filterYear' => $request->get('filterYear')
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
