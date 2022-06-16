<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Models\BMS\Mapping;
use App\Models\Employee\Employee;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MappingController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EP',
                'ELK',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }

        \View::share([
            'masters' => $masters,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['regions'] = Master::select('id', 'name')
            ->where('category', 'ELK')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();

        $sql = Employee::active()->with('contract:rank_id,employee_id')->select('id','name','emp_number','mobile_phone');

        $data['filterRegion'] = $request->get('filterRegion') ?? ''; //GET FILTER
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filterRegion']))
            $sql->where('employee_contracts.location_id', $data['filterRegion']);
//        if (!empty($data['filterBuilding']))
//            $sql->where('t1.building_id', $data['filterBuilding']);
//        if (!empty($data['filter']))
//            $sql->where('t1.name', 'like', '%' . $data['filter'] . '%')
//                ->orWhere('t1.employee_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['employees'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('bms.mappings.index', $data) : abort(401);
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
        $data['id'] = $id;
        $data['emp'] = Employee::with('contract:employee_id,rank_id')->find($id);
        $areas = DB::table('app_masters as t1')->join('bms_buildings as t2', function ($join){
            $join->on('t1.id', 't2.region_id');
            $join->on('t1.category', DB::raw('"ELK"'));
        })->select('t1.id', 't2.name', 't2.id as idArea', 't2.region_id')
            ->get();
        foreach ($areas as $key => $value){
            $data['areas'][$value->region_id][$value->idArea] = $value->name;
        }

        //GET LIST ACCESS
        $listAccess = Mapping::select('id','region_id', 'building_id', 'service')
            ->where('employee_id', $id)
            ->get();

        foreach ($listAccess as $key => $value){
            $data['areaAccess'][$value->region_id][$value->building_id] = $value->service;
        }

        return !empty(access('index')) ? view('bms.mappings.form', $data) : abort(401);

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
        Mapping::where('employee_id', $id)->delete();
        if(is_array($request->services)) {
            foreach ($request->services as $key => $buildings) {
                foreach ($buildings as $building => $service){
                    $services = implode(',', $service);
                    Mapping::create([
                        'employee_id' => $id,
                        'region_id' => $key,
                        'building_id' => $building,
                        'service' => $services
                    ]);
                }
            }
        }

        Alert::success('Success', 'Mapping Berhasil Disimpan');

        return redirect()->route('bms.mappings.index');
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
