<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\BMS\MasterRequest;
use App\Models\BMS\Target;
use App\Models\Setting\Master;
use App\Models\BMS\Master as ActivityMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->defaultStatus = defaultStatus();
        $controlType = array("1" => "Checklist", "2" => "Parameter", "3" => "Isian");
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'BKIV',
                'BKST',
                'BKA',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }

        \View::share([
            'status' => $this->defaultStatus,
            'masters' => $masters,
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
        $getCode = $this->menu()->parameter;
        $getIdService = Master::where('code', $getCode)->first()->id;
        $sql = DB::table('app_masters')->where('parent_id', $getIdService)
            ->where('category', 'BOB')
            ->orderBy('order', 'asc');
        $data['totalTarget'] = DB::table('bms_targets')
            ->select('object_id', DB::raw('COUNT(id) as totalTarget'))
            ->groupBy('object_id')
            ->pluck('totalTarget', 'object_id');
        $data['totalActivities'] = DB::table('bms_masters')
            ->select('object_id', DB::raw('COUNT(id) as totalActivities'))
            ->groupBy('object_id')
            ->pluck('totalActivities', 'object_id');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['masters'] = $sql->paginate($this->defaultPagination($request));

        return view('bms.masters.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $getCode = $this->menu()->parameter;
        $getIdService = Master::where('code', $getCode)->first()->id;
        $data['filter'] = $request->get('filter');
        $data['filterObject'] = $request->get('filterObject') ?? $id; //GET FILTER OBJECT
        $sql = Target::query()->where('object_id', $data['filterObject']);
        $data['objects'] = Master::where('category', 'BOB')
            ->where('parent_id', $getIdService)
            ->pluck('name', 'id')
            ->toArray(); // GET DATA MASTER OBJECT
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['id'] = $data['filterObject'];
        $data['targets'] = $sql->paginate($this->defaultPagination($request));

        return view('bms.masters.detail', $data);
    }

    public function activityCreate(Request $request, $id)
    {
        $data['targetId'] = array_key_first($request->all());
        $getCode = $this->menu()->parameter;
        $getIdService = Master::where('code', $getCode)->first()->id;
        $data['id'] = $id;
        $data['objects'] = Master::where('parent_id', $getIdService)
            ->where('category', 'BOB')
            ->pluck('name', 'id')
            ->toArray();
        $data['subobjects'] = Target::where('object_id', $id)
            ->pluck('name', 'id')
            ->toArray();
        $data['categories'] = Master::where('parent_id', $getIdService)
            ->where('category', 'BKA')
            ->pluck('name', 'id')
            ->toArray();
        $lastOrder = ActivityMaster::orderBy('order', 'desc');
        if($data['targetId'])
            $lastOrder->where('target_id', $data['targetId']);
        $data['lastOrder'] = $lastOrder->first()->order ?? 0;
        $getLastNumber = ActivityMaster::orderBy('code', 'desc')
                ->pluck('code')
                ->first() ?? 0;
        $data['lastCode'] = 'AKT'.Str::padLeft(intval(Str::substr($getLastNumber,3,4)) + 1, '4', '0');

        return view('bms.masters.form_activity', $data);
    }

    public function activityStore(MasterRequest $request, $id)
    {
        $service_id = Master::find($request->object_id)->parent_id;
        ActivityMaster::create([
            'service_id' => $service_id,
            'object_id' => $request->object_id,
            'target_id' => $request->target_id,
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'control_type' => $request->control_type,
            'control_parameter' => $request->control_type == 3 ? implode(',', array($request->range_1, $request->range_2)) : $request->control_parameter,
            'control_unit_id' => $request->control_unit_id,
            'interval_id' => $request->interval_id,
            'description' => $request->description,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'Master Aktifitas Berhasil Disimpan');

        return redirect()->route('bms.'.$this->menu()->target.'.show', $id);
    }

    public function activityEdit($id)
    {
        $data['master'] = ActivityMaster::find($id);
        $getCode = $this->menu()->parameter;
        $getIdService = Master::where('code', $getCode)->first()->id;
        if(!empty($data['master']->control_parameter))
            list($data['master']->range_1, $data['master']->range_2) = explode(",", $data['master']->control_parameter);
        $data['objects'] = Master::where('parent_id', $getIdService)
            ->where('category', 'BOB')
            ->pluck('name', 'id')
            ->toArray();
        $data['subobjects'] = Target::where('object_id', $data['master']->object_id)
            ->pluck('name', 'id')
            ->toArray();
        $data['categories'] = Master::where('parent_id', $getIdService)
            ->where('category', 'AKKA')
            ->pluck('name', 'id')
            ->toArray();
        $data['id'] = $id;

        return view('bms.masters.form_activity', $data);
    }

    public function activityUpdate(MasterRequest $request, $id)
    {
        $master = ActivityMaster::find($id);
        $master->object_id = $request->object_id;
        $master->target_id = $request->target_id;
        $master->name = $request->name;
        $master->code = $request->code;
        $master->category_id = $request->category_id;
        $master->control_type = $request->control_type;
        $master->control_parameter = $request->control_type == 3 ? implode(',', array($request->range_1, $request->range_2)) : $request->control_parameter;
        $master->control_unit_id = $request->control_unit_id;
        $master->interval_id = $request->interval_id;
        $master->description = $request->description;
        $master->order = $request->order;
        $master->status = $request->status;
        $master->save();

        Alert::success('Success', 'Master Aktifitas Berhasil Disimpan');

        return redirect()->route('bms.'.$this->menu()->target.'.show', $master->object_id);
    }

    public function activityDestroy($id)
    {
        $activity = ActivityMaster::find($id)->delete();

        Alert::success('Success', 'Activity berhasil dihapus');

        return redirect()->back();
    }

    public function getTargets($id)
    {
        $targets = DB::table("bms_targets")
            ->where("object_id",$id)
            ->pluck("name","id");

        return json_encode($targets);
    }

    public function subMasters($id)
    {
        $masters = DB::table("app_masters")
            ->where("parent_id",$id)
            ->pluck("name","id");

        return json_encode($masters);
    }

    public function getLastOrder($objectId, $targetId)
    {
        $lastOrder = ActivityMaster::where('object_id', $objectId)
                ->where('target_id', $targetId)
                ->orderBy('order', 'desc')
                ->first()
                ->order ?? 0;
        $lastOrder++;

        return $lastOrder;
    }
}
