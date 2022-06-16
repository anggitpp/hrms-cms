<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoring\ReportRequest;
use App\Models\Monitoring\MonitoringReport;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->get('filter') ?? '';
        $data['filterMonth'] = $request->get('filterMonth');
        $data['filterYear'] = $request->get('filterYear');
        $data['filterLocation'] = $request->get('filterLocation');

        $data['locations'] = Master::where('category', 'ELK')->pluck('name', 'id')->toArray();

        $sql = DB::table('monitoring_reports as t1')->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('employee_contracts as t3', function ($join){
                $join->on('t2.id', 't3.employee_id');
                $join->where('t3.status', 't');
            })
            ->select('t1.*', 't2.name', 't2.emp_number');
        //FILTER REGION IF NOT EMPTY THEN WHERE REGION
        if(!empty($data['filterLocation']))
            $sql->where('t3.location_id', $data['filterLocation']);
        //FILTER SEARCH IF NOT EMPTY THEN WHERE SEARCH
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where

        $data['reports'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('monitorings.reports.index', $data) : abort(401);
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
        $data['report'] = MonitoringReport::with('employee', 'contract')->find($id);

        return view('monitorings.reports.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $id)
    {
        MonitoringReport::find($id)->update([
            'date' => resetDate($request->date),
            'time' => $request->time,
            'description' => $request->description,
            'location' => $request->location,
        ]);

        Alert::success('Success', 'Laporan/Temuan berhasil disimpan');

        return redirect()->route('monitorings.reports.index');
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
