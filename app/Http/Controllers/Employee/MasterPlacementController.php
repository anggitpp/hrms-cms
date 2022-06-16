<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\MasterPlacementRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\MasterPlacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MasterPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = MasterPlacement::query();
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['employees'] = Employee::select('id', 'name')->pluck('name', 'id')->toArray();
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['placements'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('employees.placements.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::select(DB::raw("CONCAT(emp_number,' - ', name) as name"), 'id')->active()->pluck('name', 'id')->toArray();
        $data['status'] = defaultStatus();

        return !empty(access('index')) ? view('employees.placements.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterPlacementRequest $request)
    {
        MasterPlacement::create([
            'name' => $request->name,
            'leader_id' => $request->leader_id,
            'administration_id' => $request->administration_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        Alert::success('Success', 'Data Penempatan berhasil disimpan');

        return redirect()->route('employees.placements.index');
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
        $data['placement'] = MasterPlacement::find($id);
        $data['employees'] = Employee::select(DB::raw("CONCAT(emp_number,' - ', name) as name"), 'id')->pluck('name', 'id')->toArray();
        $data['status'] = defaultStatus();

        return !empty(access('edit')) ? view('employees.placements.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterPlacementRequest $request, $id)
    {
        $placement = MasterPlacement::find($id);
        $placement->name = $request->name;
        $placement->leader_id = $request->leader_id;
        $placement->administration_id = $request->administration_id;
        $placement->description = $request->description;
        $placement->status = $request->status;
        $placement->save();

        Alert::success('Success', 'Data Penempatan berhasil disimpan');

        return redirect()->route('employees.placements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterPlacement::find($id)->delete();

        Alert::success('Success', 'Data Penempatan berhasil dihapus');

        return redirect()->back();
    }
}
