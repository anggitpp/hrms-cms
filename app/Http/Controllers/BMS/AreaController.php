<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\BMS\AreaRequest;
use App\Http\Requests\BMS\ObjectRequest;
use App\Http\Requests\BMS\ShiftRequest;
use App\Models\BMS\Area;
use App\Models\BMS\AreaObject;
use App\Models\BMS\Building;
use App\Models\BMS\Shift;
use App\Models\BMS\Target;
use App\Models\Employee\Employee;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AreaController extends Controller
{
    public function __construct()
    {
        $controlType = array("1" => "Checklist", "2" => "Parameter", "3" => "Isian");
        $getCode = $this->menu()->parameter ?? 0;
        $this->idService = $getCode ? Master::where('code', $getCode)->first()->id : 0;
        $this->masters = DB::table('app_masters')
            ->select('id', 'name', 'category')
            ->whereIn('category', [
                'ELK',
                'BTP',
                'BLY',
                'BOB',
                'BKIV',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value) {
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();
        $this->photoPath = '/uploads/area/building/';

        \View::share([
            'masters' => $masters,
            'status' => $this->defaultStatus,
            'photoPath' => $this->photoPath,
            'shiftOption' => array('t' => 'Shift Gedung', 'f' => 'Shift Khusus'),
            'yesOrNo' => yesOrNoOption(),
            'finishOption' => yesOrNoOption(),
            'controlType' => $controlType
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

        //SET COMBO REGION
        $data['regions'] = Master::select('id', 'name')->where('category', 'ELK')
            ->orderBy('id')
            ->pluck('name', 'id')
            ->toArray();

        $sql = DB::table('bms_buildings')->where('services', 'like', '%'.$this->idService.'%');

        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filterRegion']))
            $sql->where('region_id', $data['filterRegion']);
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where

        $data['totalArea'] = DB::table('bms_areas')
            ->select('building_id', DB::raw('COUNT(id) as totalArea'))
            ->where('service_id', $this->idService)
            ->groupBy('building_id')
            ->pluck('totalArea', 'building_id');

        $data['buildings'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('bms.areas.index', $data) : abort(401);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function areas($id)
    {
        $data['areas'] = Area::where('building_id', $id)
            ->where('service_id', $this->idService)
            ->get();
        $data['building'] = Building::find($id);
        $data['totalObjects'] = AreaObject::select('area_id', DB::raw('COUNT(id) as totalObjects'))
            ->groupBy('area_id')
            ->pluck('totalObjects', 'area_id');

        return !empty(access('areas')) ? view('bms.areas.areas', $data) : abort(401);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function areaCreate($id)
    {
        $data['id'] = $id;
        $data['employees'] = Employee::with('contract')
            ->pluck('name', 'id')
            ->toArray();
        $getLastNumber = Area::orderBy('code', 'desc')
                ->pluck('code')
                ->first() ?? 0;
        $data['lastCode'] = 'AR' . Str::padLeft(intval(Str::substr($getLastNumber, 2, 4)) + 1, '4', '0');
        $data['lastOrder'] = Area::where('building_id', $id)
                ->where('service_id', $this->idService)
                ->orderBy('order', 'desc')
                ->first()->order ?? 0;

        return !empty(access('area/create')) ? view('bms.areas.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function areaStore(AreaRequest $request, $id)
    {
        Area::create([
            'building_id' => $id,
            'service_id' => $this->idService,
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'description' => $request->description,
            'shift' => $request->shift,
            'code' => $request->code,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => 'Area berhasil disimpan',
            'url' => route('bms.' . $this->menu()->target . '.areas', $id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function areaEdit($id)
    {
        $data['id'] = $id;
        $data['area'] = Area::find($id);
        $data['employees'] = Employee::active()
            ->pluck('name', 'id')
            ->toArray();

        return !empty(access('area/edit')) ? view('bms.areas.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function areaUpdate(AreaRequest $request, $id)
    {
        $area = Area::find($id);
        $area->name = $request->name;
        $area->employee_id = $request->employee_id;
        $area->description = $request->description;
        $area->shift = $request->shift;
        $area->code = $request->code;
        $area->order = $request->order;
        $area->status = $request->status;
        $area->save();

        return response()->json([
            'success' => 'Area berhasil disimpan',
            'url' => route('bms.' . $this->menu()->target . '.areas', $area->building_id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function areaDestroy($id)
    {
        Area::find($id)->delete();
        AreaObject::where('area_id', $id)->delete();
        Shift::where('area_id', $id)->delete();

        Alert::success('Success', 'Data gedung berhasil dihapus');

        return redirect()->back();
    }

    public function areaShifts($id)
    {
        $area = Area::find($id);
        $data['shifts'] = Shift::where('building_id', $area->building_id)
            ->where('special', 'f')
            ->where('service_id', $this->idService)
            ->orderBy('order')
            ->get();

        return view('bms.areas.shifts', $data);
    }

    public function objects(Request $request, $id)
    {
        $data['filterArea'] = $request->get('filterArea') ?? $id;
        $id = $data['filterArea'] ?? $id;
        $data['area'] = Area::find($id);
        $data['objects'] = AreaObject::where('area_id', $id)->get();
        $data['building'] = Building::find($data['area']->building_id);
        $data['totalActivities'] = DB::table('bms_masters')
            ->where('service_id', $this->idService)
            ->select('object_id', DB::raw('COUNT(id) as totalActivities'))
            ->groupBy('object_id')
            ->pluck('totalActivities', 'object_id');
        $data['id'] = $id;

        return !empty(access('objects')) ? view('bms.areas.objects', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function objectCreate(Request $request, $id)
    {
        $data['id'] = $request->get('filterArea') ?? $id;
        $data['employees'] = Employee::pluck('name', 'id')
            ->toArray();
        $data['categories'] = Master::where('category', 'BOB')
            ->where('parent_id', $this->idService)
            ->pluck('name', 'id')
            ->toArray();
        $getLastNumber = AreaObject::orderBy('code', 'desc')
                ->pluck('code')
                ->first() ?? 0;
        $data['lastCode'] = 'OB' . Str::padLeft(intval(Str::substr($getLastNumber, 2, 4)) + 1, '4', '0');
        $data['lastOrder'] = AreaObject::where('area_id', $data['id'])
                ->orderBy('order', 'desc')
                ->first()->order ?? 0;

        return !empty(access('object/create')) ? view('bms.areas.object_form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function objectStore(ObjectRequest $request, $id)
    {
        $area = Area::find($id);

        AreaObject::create([
            'service_id' => $this->idService,
            'building_id' => $area->building_id,
            'area_id' => $id,
            'object_id' => $request->object_id,
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'description' => $request->description,
            'shift' => $request->shift,
            'code' => $request->code,
            'qr' => $request->qr,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'Object berhasil disimpan');

        return redirect()->route('bms.'.$this->menu()->target.'.objects', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function objectEdit($id)
    {
        $data['object'] = AreaObject::find($id);
        $data['employees'] = Employee::pluck('name', 'id')
            ->toArray();
        $data['categories'] = Master::where('category', 'BOB')
            ->where('parent_id', $this->idService)
            ->pluck('name', 'id')
            ->toArray();

        return !empty(access('object/edit')) ? view('bms.areas.object_form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function objectUpdate(ObjectRequest $request, $id)
    {
        $object = AreaObject::find($id);

        $object->object_id = $request->object_id;
        $object->name = $request->name;
        $object->employee_id = $request->employee_id;
        $object->description = $request->description;
        $object->shift = $request->shift;
        $object->code = $request->code;
        $object->qr = $request->qr;
        $object->order = $request->order;
        $object->status = $request->status;
        $object->save();

        Alert::success('Success', 'Object berhasil disimpan');

        return redirect()->route('bms.'.$this->menu()->target.'.objects', $object->area_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function objectDestroy($id)
    {
        AreaObject::find($id)->delete();

        Alert::success('Success', 'Data objek berhasil dihapus');

        return redirect()->back();
    }

    public function objectActivities($id)
    {
        $data['object'] = AreaObject::find($id);
        $data['targets'] = Target::where('service_id', $data['object']->service_id)
            ->where('object_id', $data['object']->object_id)
            ->get();

        return view('bms.areas.activities', $data);
    }

    public function shifts(Request $request, $id)
    {
        $data['area'] = Area::find($id);
        $data['building'] = Building::find($data['area']->building_id);
        $data['shifts'] = Shift::where('area_id', $id)->get();
        $data['areas'] = Area::where('building_id', $data['area']->building_id)
            ->where('service_id', $this->idService)
            ->pluck('name', 'id')
            ->toArray();
        $data['id'] = $id;

        return view('bms.areas.special_shifts', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shiftCreate($id)
    {
        $data['id'] = $id;
        $data['lastOrder'] = Shift::where('area_id', $data['id'])
                ->orderBy('order', 'desc')
                ->first()->order ?? 0;

        return view('bms.areas.shift_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shiftStore(ShiftRequest $request, $id)
    {
        $area = Area::find($id);

        Shift::create([
            'building_id' => $area->building_id,
            'service_id' => $this->idService,
            'area_id' => $id,
            'name' => $request->name,
            'code' => $request->code,
            'start' => $request->start,
            'end' => $request->end,
            'interval_id' => $request->interval_id,
            'finish_today' => $request->finish_today,
            'description' => $request->description,
            'status' => $request->status,
            'order' => $request->order,
            'special' => 't'
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

        return view('bms.areas.shift_form', $data);
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
            'url'=> route('bms.'.$this->menu()->target.'.shifts', $shift->area_id)
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

}
