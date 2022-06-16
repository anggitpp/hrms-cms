<?php

namespace App\Http\Controllers\BMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\BMS\TargetRequest;
use App\Models\BMS\Target;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TargetController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'BOB',
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

        \View::share([
            'masters' => $masters,
            'status' => $this->defaultStatus,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('bms_targets');
        $data['services'] = Master::where('category', 'BLY')
            ->orderBy('order', 'asc')
            ->pluck('name', 'id')
            ->toArray();
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterService'] = $request->get('filterService') ?? array_key_first($data['services']); //GET FILTER SERVICE, DEFAULT GET FIRST SERVICES
        $data['filterObject'] = $request->get('filterObject'); //GET FILTER OBJECT
        $sql->where('service_id', $data['filterService']);
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        if(!empty($data['filterObject'])) //CHECK IF NOT EMPTY FILTER OBJECT THEN WHERE
            $sql->where('object_id', $data['filterObject']);
        $data['objects'] = Master::where('category', 'BOB')
            ->where('parent_id', $data['filterService'])
            ->pluck('name', 'id')
            ->toArray(); // GET DATA MASTER OBJECT
        $data['targets'] = $sql->paginate($this->defaultPagination($request));

        return view('bms.targets.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $getLastNumber = Target::orderBy('code', 'desc')
                ->pluck('code')
                ->first() ?? 0;
        $data['lastCode'] = 'SA'.Str::padLeft(intval(Str::substr($getLastNumber,2,3)) + 1, '3', '0');
        $data['selectedService'] = $id;
        $data['objects'] = Master::where('parent_id', $id)
            ->where('category', 'BOB')
            ->pluck('name', 'id')
            ->toArray();

        return view('bms.targets.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TargetRequest $request)
    {
        Target::create([
            'name' => $request->name,
            'service_id' => $request->service_id,
            'object_id' => $request->object_id,
            'code' => $request->code,
            'description' => $request->description,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'Sasaran Berhasil Disimpan');

        return redirect()->route('bms.targets.index');
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
        $data['target'] = Target::find($id);
        $data['objects'] = Master::where('parent_id', $data['target']->service_id)
            ->where('category', 'BOB')
            ->pluck('name', 'id')
            ->toArray();

        return view('bms.targets.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TargetRequest $request, $id)
    {
        $target = Target::find($id);
        $target->service_id = $request->service_id;
        $target->object_id = $request->object_id;
        $target->name = $request->name;
        $target->code = $request->code;
        $target->description = $request->description;
        $target->order = $request->order;
        $target->status = $request->status;
        $target->save();

        Alert::success('Success', 'Sasaran Berhasil Disimpan');

        return redirect()->route('bms.targets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $target = Target::find($id);

        //TODO : FINISH THIS WHEN ACTIVITY MASTER ALREADY DONE
//        ActivityMaster::where('target_id', $target->id)->delete();
        $target->delete();

        Alert::success('Success', 'Data sdm berhasil dihapus');

        return redirect()->back();
    }

    public function subMasters($id){
        $masters = DB::table("app_masters")
            ->where("parent_id",$id)
            ->where("category", 'BOB')
            ->pluck("name","id");

        return json_encode($masters);
    }
}
