<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\BMS\BuildingRequest;
use App\Models\BMS\Building;
use App\Models\Monitoring\Monitoring;
use App\Models\Setting\Master;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'ELK',
                'BTP',
                'BLY',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();
        $this->photoPath = '/uploads/bms/building/';

        \View::share([
            'masters' => $masters,
            'status' => $this->defaultStatus,
            'photoPath' => $this->photoPath,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employeeId = Auth::user()->employee_id;

        $monitoring = Monitoring::where('employee_id', $employeeId)
            ->where('date', date('Y-m-d'))
            ->where('start', '<=', '13:55')
            ->where('end', '>=', '13:55')
//            ->where('start', '=<',date('H:i'))
//            ->where('end', '>=',date('H:i'))
            ->first();
        dd($monitoring);
        //GET FILTER REGION
        $data['filterRegion'] = $getRegionFromSession ?? $request->get('filterRegion') ?? '';

        //GET LIST REGIONS
        $regions = Master::select('id', 'name');

        $data['regions'] = $regions->where('category', 'ELK')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();

        //GET LIST BUILDINGS
        $sql = Building::query();
        //GET FILTER SEARCH
        $data['filter'] = $request->get('filter');
        //FILTER REGION IF NOT EMPTY THEN WHERE REGION
        if(!empty($data['filterRegion']))
            $sql->where('region_id', $data['filterRegion']);
        //FILTER SEARCH IF NOT EMPTY THEN WHERE SEARCH
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where

        $data['buildings'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('bms.buildings.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getLastNumber = Building::orderBy('code', 'desc')
                ->pluck('code')
                ->first() ?? 0;
        //GET DEFAULT BUILDING FROM SESSION
        $data['sessionBuilding'] = DB::table('bms_buildings as t1')->join('app_masters as t2', 't1.region_id', 't2.id')
            ->select('t2.id as regionId', 't2.name as regionName')
            ->first();

        $data['lastCode'] = 'GD'.Str::padLeft(intval(Str::substr($getLastNumber,2,3)) + 1, '3', '0');

        return !empty(access('create')) ? view('bms.buildings.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuildingRequest $request)
    {
        $services = implode(',', $request->services);
        $photo = uploadFile(
            $request->file('photo'),
            Str::slug($request->input('name')).'_'.time(),
            $this->photoPath);

        Building::create([
            'name' => $request->name,
            'region_id' => $request->region_id,
            'type_id' => $request->type_id,
            'code' => $request->code,
            'address' => $request->address,
            'photo' => $photo,
            'status' => $request->status,
            'services' => $services
        ]);

        Alert::success('Success', 'Data gedung berhasil disimpan');

        return redirect()->route('bms.buildings.index');
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
        $data['building'] = Building::find($id);

        $data['listServices'] = explode(',', $data['building']->services);

        return !empty(access('create')) ? view('bms.buildings.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BuildingRequest $request, $id)
    {
        $services = implode(',', $request->services);
        $building = Building::find($id);
        $photo = $request->exist_photo ? $building->photo : '';
        if($building->photo && $photo == '')
            \Storage::disk('public')->delete($building->photo);
        if($request->file('photo')){
            Storage::disk('public')->delete($building->photo);
            $photo = uploadFile($request->file('photo'), Str::slug($request->input('name')).'_'.time(), $this->photoPath);
        }
        $building->name = $request->name;
        $building->code = $request->code;
        $building->region_id = $request->region_id;
        $building->type_id = $request->type_id;
        $building->address = $request->address;
        $building->status = $request->status;
        $building->services = $services;
        $building->photo = $photo;
        $building->save();

        Alert::success('Success', 'Data gedung berhasil disimpan');

        return redirect()->route('bms.buildings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $building = Building::find($id);
        Storage::disk('public')->delete($building->photo);
        $building->delete();

//        Area::where('building_id', $id)->delete();
//        AreaObject::where('building_id', $id)->delete();
//        Shift::where('building_id', $id)->delete();

        Alert::success('Success', 'Data gedung berhasil dihapus');

        return redirect()->back();
    }
}
