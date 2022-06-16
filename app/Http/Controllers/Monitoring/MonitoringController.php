<?php

namespace App\Http\Controllers\Monitoring;

use App\Exports\Monitoring\MonitoringReport;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Monitoring\Monitoring;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->get('filter') ?? '';
        $data['filterMonth'] = $request->get('filterMonth') ?? date('m');
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $data['filterLocation'] = $request->get('filterLocation');
        $data['locations'] = Master::where('category', 'ELK')->pluck('name', 'id')->toArray();

        //GET TOTAL DAYS IN MONTH
        $data['totalDays'] = cal_days_in_month(CAL_GREGORIAN, $data['filterMonth'], $data['filterYear']);

        //GET LIST ATTENDANCE IN SELECTED MONTH AND YEAR
        $monitorings = Monitoring::select('employee_id', DB::raw('day(date) as day'), DB::raw('COUNT(id) as totalMonitoring'))
            ->whereMonth('date', $data['filterMonth'])
            ->whereYear('date', $data['filterYear'])
            ->whereNotNull('actual')
            ->groupBy('date', 'employee_id')
            ->get();

        //MAKE ARRAY FROM COLLECTION
        foreach ($monitorings as $key => $value)
        {
            $data['monitorings'][$value->employee_id][$value->day] = $value->totalMonitoring;
        }

        //GET QUERY EMPLOYEE
        $sql = DB::table('employees as t1')->join('employee_contracts as t2', function ($join){
                $join->on('t1.id', 't2.employee_id');
                $join->where('t2.status', 't');
            })
            ->select('t1.id','t1.name', 't1.emp_number');
        //FILTER REGION IF NOT EMPTY THEN WHERE REGION
        if(!empty($data['filterLocation']))
            $sql->where('t2.location_id', $data['filterLocation']);
        //FILTER SEARCH IF NOT EMPTY THEN WHERE SEARCH
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where

        $data['employees'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('monitorings.monitorings.index', $data) : abort(401);
    }

    /**
     * Export data
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        return Excel::download(new MonitoringReport([
            'filter' => $request->get('filter'),
            'filterLocation' => $request->get('filterLocation'),
            'filterMonth' => $request->get('filterMonth'),
            'filterYear' => $request->get('filterYear')
        ]), 'Data Monitoring.xlsx');
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
    public function show(Request $request, $employeeId, $day)
    {
        $data['date'] = implode('-', [$request->get('filterYear'), $request->get('filterMonth'), $day]);

        $data['monitorings'] = Monitoring::where('employee_id', $employeeId)->where('date', $data['date'])->get();
        $data['emp'] = Employee::find($employeeId);

        return view('monitorings.monitorings.detail', $data);
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
