<?php

namespace App\Http\Controllers\ESS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceLeaveMasterRequest;
use App\Models\ESS\AttendanceLeaveMaster;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceLeaveMasterController extends Controller
{
    public function __construct()
    {
        $this->genders = array('a' => 'Semua', 'm' => 'Laki-Laki', 'f' => 'Perempuan');
        $this->locations = Master::where('category', 'ELK')->pluck('name', 'id')->toArray();

        \View::share([
            'genders' => $this->genders,
            'locations' => $this->locations,
            'status' => defaultStatus(),
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->get('filter') ?? '';
        $masters = AttendanceLeaveMaster::query();
        if(!empty($data['filter']))
            $masters->where('name', 'like', '%' . $data['filter'] . '%');
        $data['masters'] = $masters->paginate($this->defaultPagination($request));

        return view('ess.leave_masters.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ess.leave_masters.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceLeaveMasterRequest $request)
    {
        AttendanceLeaveMaster::create([
            'name' => $request->name,
            'quota' => $request->quota,
            'start_date' => resetDate($request->start_date),
            'end_date' => resetDate($request->end_date),
            'working_life' => $request->working_life,
            'gender' => $request->gender,
            'description' => $request->description,
            'location_id' => $request->location_id,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'Data Master Cuti berhasil disimpan');

        return redirect()->route('ess.leave_masters.index');
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
        $data['master'] = AttendanceLeaveMaster::find($id);

        return view('ess.leave_masters.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceLeaveMasterRequest $request, $id)
    {
        $master = AttendanceLeaveMaster::find($id);
        $master->name = $request->name;
        $master->quota = $request->quota;
        $master->start_date = resetDate($request->start_date);
        $master->end_date = resetDate($request->end_date);
        $master->working_life = $request->working_life;
        $master->gender = $request->gender;
        $master->description = $request->description;
        $master->location_id = $request->location_id;
        $master->status = $request->status;
        $master->save();

        Alert::success('Success', 'Data Master Cuti berhasil disimpan');

        return redirect()->route('ess.leave_masters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AttendanceLeaveMaster::find($id)->delete();

        Alert::success('Success', 'Data Master Cuti berhasil dihapus');

        return redirect()->back();
    }
}
