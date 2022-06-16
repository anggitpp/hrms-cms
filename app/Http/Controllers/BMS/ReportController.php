<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Models\BMS\Building;
use App\Models\BMS\Report;
use App\Models\Setting\Master;
use Illuminate\Http\Request;

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
        $data['filterRegion'] = $request->get('filterRegion') ?? '';

        $data['regions'] = Master::where('category', 'ELK')->pluck('name', 'id')->toArray();
        $data['buildings'] = Building::pluck('name', 'id')->toArray();

        $sql = Report::query();
        //FILTER REGION IF NOT EMPTY THEN WHERE REGION
        if(!empty($data['filterRegion']))
            $sql->where('region_id', $data['filterRegion']);
        //FILTER BUILDING IF NOT EMPTY THEN WHERE BUILDING
        if(!empty($data['filterBuilding']))
            $sql->where('building_id', $data['filterBuilding']);
        //FILTER SEARCH IF NOT EMPTY THEN WHERE SEARCH
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where

        $data['reports'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('bms.reports.index', $data) : abort(401);
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
