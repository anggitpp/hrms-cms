<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ArchiveEducationRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class EducationController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'EP',
                'SPD'
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }
        $this->educationPath = '/uploads/employee/education/';

        \View::share([
            'masters' => $masters,
            'educationPath' => $this->educationPath,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('employee_education as t1')
            ->select('t1.id', 't1.name as educationName', 't1.level_id', 't1.major', 't1.filename', 't2.name', 't2.emp_number',
                't3.position_id')
            ->join('employees as t2','t1.employee_id', 't2.id')
            ->join('employee_contracts as t3', function ($join){
                $join->on('t2.id', 't3.employee_id');
                $join->where('t3.status', 't');
            });
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('t2.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                ->orWhere('t1.name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['education'] = $sql->paginate($this->defaultPagination($request));

        return view('employees.education.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();

        return view('employees.education.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveEducationRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->educationPath);

        EmployeeEducation::create([
            'employee_id' => $request->employee_id,
            'level_id' => $request->level_id,
            'name' => $request->name,
            'major' => $request->major,
            'essay' => $request->essay,
            'city' => $request->city,
            'score' => $request->score,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'filename' => $filename,
            'description' => $request->description
        ]);

        Alert::success('Success', 'Education created successfully');

        return redirect()->route('employees.education.index');
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
        $data['edu'] = EmployeeEducation::find($id);
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();
        $data['emp'] = Employee::find($data['edu']->employee_id);

        return view('employees.education.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArchiveEducationRequest $request, $id)
    {
        $education = EmployeeEducation::find($id);

        $filename = $request->exist_filename ? $education->filename : '';
        if($education->filename && $filename == '')
            \Storage::disk('public')->delete($education->filename);
        if($request->file('filename')){
            \Storage::disk('public')->delete($education->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->educationPath);
        }

        $education->employee_id = $request->employee_id;
        $education->name = $request->name;
        $education->level_id = $request->level_id;
        $education->major = $request->major;
        $education->score = $request->score;
        $education->city = $request->city;
        $education->start_year = $request->start_year;
        $education->end_year = $request->end_year;
        $education->essay = $request->essay;
        $education->filename = $filename;
        $education->description = $request->description;
        $education->save();

        Alert::success('Success', 'Education updated successfully');

        return redirect()->route('employees.education.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $education = EmployeeEducation::find($id);
        Storage::disk('public')->delete($education->filename);
        $education->delete();

        Alert::success('Success', 'Education deleted successfully');

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
