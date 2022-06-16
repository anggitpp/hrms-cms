<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ArchiveContractRequest;
use App\Models\Attendance\AttendanceShift;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'EP',
                'EDP',
                'ETP',
                'EG',
                'ELK',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();
        $this->contractPath = '/uploads/employee/contract/';

        \View::share([
            'contractPath' => $this->contractPath,
            'status' => $this->defaultStatus,
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
        $sql = DB::table('employee_contracts as t1')
            ->select('t1.id', 't1.rank_id', 't1.position_id', 't1.start_date', 't1.end_date', 't1.filename', 't2.name', 't2.emp_number')
            ->join('employees as t2','t1.employee_id', 't2.id');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('t2.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['contracts'] = $sql->paginate($this->defaultPagination($request));

        return view('employees.contracts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();

        return view('employees.contracts.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveContractRequest $request)
    {
        $emp = Employee::find($request->employee_id);
        if($request->status == 't')
            DB::table('employee_contracts')->where('employee_id', $request->employee_id)->update(['status' => 'f']);

        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($emp->name).'_'.time(),
            $this->contractPath);

        EmployeeContract::create([
            'employee_id' => $request->employee_id,
            'position_id' => $request->position_id,
            'type_id' => $request->type_id,
            'rank_id' => $request->rank_id,
            'grade_id' => $request->grade_id,
            'sk_number' => $request->sk_number,
            'location_id' => $request->location_id,
            'start_date' => resetDate($request->start_date),
            'end_date' => $request->end_date ? resetDate($request->end_date) : '',
            'placement_id' => $request->placement_id,
            'shift_id' => $request->shift_id,
            'status' => $request->status,
            'description' => $request->description,
            'filename' => $filename,
        ]);

        Alert::success('Success', 'Contract created successfully');

        return redirect()->route('employees.contracts.index');
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
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['contract'] = EmployeeContract::find($id);
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();
        $data['emp'] = Employee::find($data['contract']->employee_id);

        return view('employees.contracts.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArchiveContractRequest $request, $id)
    {
        $emp = Employee::find($request->employee_id);
        if($request->status == 't')
            DB::table('employee_contracts')->where('employee_id', $emp->id)->update(['status' => 'f']);

        $contract = EmployeeContract::find($id);
        $filename = $request->exist_filename ? $contract->filename : '';
        if($contract->filename && $filename == '')
            \Storage::disk('public')->delete($contract->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($contract->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($emp->name).'_'.time(), $this->contractPath);
        }

        $contract->employee_id = $request->employee_id;
        $contract->position_id = $request->position_id;
        $contract->type_id = $request->type_id;
        $contract->rank_id = $request->rank_id;
        $contract->grade_id = $request->grade_id;
        $contract->sk_number = $request->sk_number;
        $contract->location_id = $request->location_id;
        $contract->start_date = resetDate($request->start_date);
        $contract->end_date = $request->end_date ? resetDate($request->end_date) : '';
        $contract->placement_id = $request->placement_id;
        $contract->shift_id = $request->shift_id;
        $contract->status = $request->status;
        $contract->description =  $request->description;
        $contract->filename = $filename;
        $contract->save();

        Alert::success('Success', 'Contract updated successfully');

        return redirect()->route('employees.contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = EmployeeContract::find($id);
        Storage::disk('public')->delete($contract->filename);
        $contract->delete();

        Alert::success('Success', 'Contract deleted successfully');

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
