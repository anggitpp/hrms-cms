<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ArchiveWorkRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class WorkController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'EP',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }
        $this->workPath = '/uploads/employee/work/';

        \View::share([
            'workPath' => $this->workPath,
            'masters'=> $masters
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('employee_works as t1')
            ->select('t1.id', 't1.company', 't1.position', 't1.start_date', 't1.end_date', 't1.filename', 't2.name', 't2.emp_number')
            ->join('employees as t2','t1.employee_id', 't2.id');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('t2.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                ->orWhere('t1.company', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['works'] = $sql->paginate($this->defaultPagination($request));

        return view('employees.works.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();

        return view('employees.works.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveWorkRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('company')).'_'.time(),
            $this->workPath);

        EmployeeWork::create([
            'employee_id' => $request->employee_id,
            'company' => $request->company,
            'position' => $request->position,
            'start_date' => resetDate($request->start_date),
            'end_date' => $request->end_date ? resetDate($request->end_date) : '',
            'city' => $request->city,
            'job_desc' => $request->job_desc,
            'filename' => $filename,
            'description' => $request->description
        ]);

        Alert::success('Success', 'Work Experience created successfully');

        return redirect()->route('employees.works.index');
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
        $data['work'] = EmployeeWork::find($id);
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();
        $data['emp'] = Employee::find($data['work']->employee_id);

        return view('employees.works.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArchiveWorkRequest $request, $id)
    {
        $work = EmployeeWork::find($id);

        $filename = $request->exist_filename ? $work->filename : '';
        if($work->filename && $filename == '')
            \Storage::disk('public')->delete($work->filename);
        if($request->file('filename')){
            \Storage::disk('public')->delete($work->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->workPath);
        }

        $work->employee_id = $request->employee_id;
        $work->company = $request->company;
        $work->position = $request->position;
        $work->start_date = resetDate($request->start_date);
        $work->end_date = $request->end_date ? resetDate($request->end_date) : '';
        $work->city = $request->city;
        $work->job_desc = $request->job_desc;
        $work->filename = $filename;
        $work->description = $request->description;
        $work->save();

        Alert::success('Success', 'Work Experience updated successfully');

        return redirect()->route('employees.works.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = EmployeeWork::find($id);
        Storage::disk('public')->delete($work->filename);
        $work->delete();

        Alert::success('Success', 'Work Experience deleted successfully');

        return redirect()->back();
    }

    public function getDetail($id){
        $datas = DB::table('employees')
            ->select('employees.emp_number', 'employee_contracts.position_id', 'employee_contracts.rank_id')
            ->join('employee_contracts', function ($join){
                $join->on('employees.id', 'employee_contracts.employee_id');
                $join->where('employee_contracts.status', 't');
            })->where('employees.id', $id)->first();

        $datas->positionName = $this->listMasters['EJP'][$datas->position_id];
        $datas->rankName = $this->listMasters['EP'][$datas->rank_id];

        return json_encode($datas);
    }
}
