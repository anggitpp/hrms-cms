<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\BMS\ShiftRequest;
use App\Models\BMS\Area;
use App\Models\BMS\AreaObject;
use App\Models\BMS\Building;
use App\Models\BMS\Shift;
use App\Models\BMS\Target;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SettingController extends Controller
{
    public function __construct()
    {
        $getCode = $this->menu()->parameter ?? 0;
        $this->idService = $getCode ? Master::where('code', $getCode)->first()->id : 0;
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'BTP',
                'ELK',
                'BLY',
                'BKIV',
                'BOB',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();
        $this->photoPath = '/uploads/area/building/';

        \View::share([
            'masters' => $masters,
            'status' => $this->defaultStatus,
            'finishOption' => yesOrNoOption()
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //GET FILTER REGION
        $data['filterRegion'] = $request->get('filterRegion') ?? '';

        //GET LIST REGIONS
        $regions = Master::select('id', 'name');

        $data['regions'] = $regions->where('category', 'ELK')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();

        $sql = DB::table('bms_buildings')->where('services', 'like', '%'.$this->idService.'%');
        $data['filter'] = $request->get('filter'); //GET FILTER

        if(!empty($data['filterRegion']))
            $sql->where('region_id', $data['filterRegion']);
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['totalShift'] = DB::table('bms_shifts')
            ->select('building_id', DB::raw('COUNT(id) as totalShift'))
            ->where('service_id', $this->idService)
            ->where('special', 'f')
            ->groupBy('building_id')
            ->pluck('totalShift', 'building_id');
        $data['totalActivities'] = DB::table('bms_objects as t1')
            ->join('bms_masters as t2', 't1.object_id', 't2.object_id')
            ->select('t1.building_id', DB::raw('COUNT(t2.id) as totalActivities'))
            ->where('t1.service_id', $this->idService)
            ->groupBy('building_id')
            ->pluck('totalActivities', 'building_id');
        $data['buildings'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('bms.settings.index', $data) : abort(401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['building'] = Building::find($id);
        $data['areas'] = Area::where('building_id', $id)
            ->where('service_id', $this->idService)
            ->get();
        $data['totalActivities'] = DB::table('bms_masters')
            ->where('service_id', $this->idService)
            ->select('object_id', DB::raw('COUNT(id) as totalActivities'))
            ->groupBy('object_id')
            ->pluck('totalActivities', 'object_id');

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }

        return !empty(access('show')) ? view('bms.settings.detail', $data) : abort(401);

    }

    public function shifts($id)
    {
        $data['building'] = Building::find($id);
        $data['shifts'] = Shift::where('building_id', $id)
            ->where('service_id', $this->idService)
            ->where('special', 'f')
            ->get();

        return !empty(access('shifts')) ? view('bms.settings.shifts', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shiftCreate($id)
    {
        $data['id'] = $id;
        $data['lastOrder'] = Shift::where('building_id', $id)
                ->where('service_id', $this->idService)
                ->orderBy('order', 'desc')
                ->first()->order ?? 0;

        return view('bms.settings.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shiftStore(ShiftRequest $request, $id)
    {
        $getCode = $this->menu()->parameter;
        $getIdService = Master::where('code', $getCode)->first()->id;

        Shift::create([
            'building_id' => $id,
            'service_id' => $getIdService,
            'name' => $request->name,
            'code' => $request->code,
            'start' => $request->start,
            'end' => $request->end,
            'interval_id' => $request->interval_id,
            'finish_today' => $request->finish_today,
            'description' => $request->description,
            'status' => $request->status,
            'order' => $request->order,
            'special' => 'f'
        ]);

        return response()->json([
            'success'=>'Shift created successfully',
            'url'=> route('bms.'.$this->menu()->target.'.shifts', $id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shiftEdit($id)
    {
        $data['shift'] = Shift::find($id);

        return view('bms.settings.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shiftUpdate(ShiftRequest $request, $id)
    {
        $shift = Shift::find($id);
        $shift->name = $request->name;
        $shift->code = $request->code;
        $shift->start = $request->start;
        $shift->end = $request->end;
        $shift->interval_id = $request->interval_id;
        $shift->finish_today = $request->finish_today;
        $shift->description = $request->description;
        $shift->status = $request->status;
        $shift->order = $request->order;
        $shift->save();

        return response()->json([
            'success'=>'Shift updated successfully',
            'url'=> route('bms.'.$this->menu()->target.'.shifts', $shift->building_id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shiftDestroy($id)
    {
        Shift::find($id)->delete();

        Alert::success('success', 'Shift deleted successfully');

        return redirect()->back();
    }

    public function activities($id)
    {
        $data['object'] = AreaObject::find($id);
        $data['targets'] = Target::where('service_id', $data['object']->service_id)
            ->where('object_id', $data['object']->object_id)
            ->get();

        return view('bms.settings.activities', $data);
    }

    public function shift($id)
    {
        $data['area'] = Area::find($id);
        $shifts = Shift::where('service_id', $data['area']->service_id)
            ->where('building_id', $data['area']->building_id);
        if($data['area']->shift == 'f')
            $shifts->where('area_id', $id);
        $data['shifts'] = $shifts->get();

        return view('bms.settings.activity_shifts', $data);
    }
}
