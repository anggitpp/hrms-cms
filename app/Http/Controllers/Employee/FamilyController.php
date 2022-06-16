<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ArchiveFamilyRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class FamilyController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'EP',
                'EHK',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }
        $this->gender = array('m' => 'Laki-Laki', 'f' => 'Perempuan');
        $this->familyPath = '/uploads/employee/family/';

        \View::share([
            'masters' => $masters,
            'familyPath' => $this->familyPath,
            'gender' => $this->gender,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('employee_families as t1')
            ->select('t1.id', 't1.name as familyName', 't1.relation_id', 't1.identity_number', 't1.filename', 't2.name', 't2.emp_number',
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
        $data['families'] = $sql->paginate($this->defaultPagination($request));

        return view('employees.families.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::active()->orderBy('name')->pluck('name','id')->toArray();

        return view('employees.families.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveFamilyRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->familyPath);

        EmployeeFamily::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'relation_id' => $request->relation_id,
            'identity_number' => $request->identity_number,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'filename' => $filename,
            'birth_date' => $request->birth_date ? resetDate($request->birth_date) : '',
            'description' => $request->description
        ]);

        Alert::success('Success', 'Family created successfully');

        return redirect()->route('employees.families.index');
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
        $data['family'] = EmployeeFamily::find($id);
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();
        $data['emp'] = Employee::find($data['family']->employee_id);

        return view('employees.families.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArchiveFamilyRequest $request, $id)
    {
        $family = EmployeeFamily::find($id);

        $filename = $request->exist_filename ? $family->filename : '';
        if($family->filename && $filename == '')
            \Storage::disk('public')->delete($family->filename);
        if($request->file('filename')){
            \Storage::disk('public')->delete($family->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->familyPath);
        }
        $family->employee_id = $request->employee_id;
        $family->name = $request->name;
        $family->relation_id = $request->relation_id;
        $family->identity_number = $request->identity_number;
        $family->gender = $request->gender;
        $family->birth_place = $request->birth_place;
        $family->birth_date = $request->birth_date ? resetDate($request->birth_date) : '';
        $family->filename = $filename;
        $family->description = $request->description;
        $family->save();

        Alert::success('Success', 'Family updated successfully');

        return redirect()->route('employees.families.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $family = EmployeeFamily::find($id);
        Storage::disk('public')->delete($family->filename);
        $family->delete();

        Alert::success('Success', 'Family deleted successfully');

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
