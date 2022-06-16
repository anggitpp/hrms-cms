<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\TerminationRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeTermination;
use App\Models\Setting\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TerminationController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'ESP',
            ])
            ->where('status', 't')
            ->where('code','!=', 'ESP001')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }
        $this->terminationPath = '/uploads/employee/termination/';

        \View::share([
            'terminationPath' => $this->terminationPath,
            'status' => defaultStatusApproval(),
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
        $sql = DB::table('employee_terminations as t1')
            ->select('t1.id', 't1.termination_number', 't1.date', 't1.category_id', 't1.effective_date', 't1.filename', 't1.approve_status',
                't2.name', 't2.emp_number')
            ->join('employees as t2','t1.employee_id', 't2.id');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('t2.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                ->orWhere('t1.company', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['terminations'] = $sql->paginate($this->defaultPagination($request));

        return view('employees.terminations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::active()->orderBy('name')->pluck('name','id')->toArray();
        $getLastNumber = EmployeeTermination::where(DB::raw('year(date)'), date('Y'))
                ->orderBy('termination_number', 'desc')
                ->pluck('termination_number')
                ->first() ?? 0;
        $data['terminationNumber'] = Str::padLeft(Str::substr($getLastNumber,0,5) + 1, '5', '0').'/TRN/'.date('Y');

        return view('employees.terminations.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerminationRequest $request)
    {
        $emp = Employee::find($request->employee_id);
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($emp->name).'_'.time(),
            $this->terminationPath);

        EmployeeTermination::create([
            'employee_id' => $request->employee_id,
            'termination_number' => $request->termination_number,
            'date' => resetDate($request->date),
            'employee_id' => $request->employee_id,
            'category_id' => $request->category_id,
            'effective_date' => resetDate($request->effective_date),
            'description' => $request->description,
            'filename' => $filename,
            'note' => $request->note,
        ]);

        Alert::success('Success', 'Termination created successfully');

        return redirect()->route('employees.terminations.index');
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
        $data['termination'] = EmployeeTermination::find($id);
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();
        $data['emp'] = Employee::find($data['termination']->employee_id);

        return view('employees.terminations.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TerminationRequest $request, $id)
    {

        $termination = EmployeeTermination::find($id);
        $emp = Employee::find($request->employee_id);
        $filename = $request->exist_filename ? $termination->filename : '';
        if($termination->filename && $filename == '')
            \Storage::disk('public')->delete($termination->filename);
        if($request->file('filename')){
            \Storage::disk('public')->delete($termination->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($emp->name).'_'.time(), $this->terminationPath);
        }
        $termination->employee_id = $request->employee_id;
        $termination->termination_number = $request->termination_number;
        $termination->date = resetDate($request->date);
        $termination->employee_id = $request->employee_id;
        $termination->category_id = $request->category_id;
        $termination->effective_date = resetDate($request->effective_date);
        $termination->description = $request->description;
        $termination->filename = $filename;
        $termination->note = $request->note;
        $termination->save();

        Alert::success('Success', 'Termination updated successfully');

        return redirect()->route('employees.terminations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmployeeTermination::find($id)->delete();

        Alert::success('Success', 'Termination deleted successfully');

        return redirect()->back();
    }

    public function approveEdit($id)
    {
        $data['termination'] = EmployeeTermination::find($id);
        $data['user'] = User::find($data['termination']->approve_by);

        return view('employees.terminations.approve_form', $data);
    }

    public function approveUpdate(Request $request, $id)
    {
        $termination = EmployeeTermination::find($id);
        $employee = Employee::find($termination->employee_id);
        $termination->approve_by = \Auth::user()->id;
        $termination->approve_date = resetDate($request->approve_date);
        $termination->approve_note = $request->approve_note;
        $termination->approve_status = $request->approve_status;
        $termination->save();

        if($termination->approve_status == 't') {
            $employee->status_id = $termination->category_id;
            $employee->leave_date = $termination->effective_date;
            $employee->save();
        }

        Alert::success('Success', 'Termination approved successfully');

        return redirect()->route('employees.terminations.index');
    }

//    public function approveCreate($id)
//    {
//        return view('employees.terminations.approve_form');
//    }

    public function getDetail($id){
        $datas = DB::table('employees')
            ->select('employees.emp_number', 'employee_contracts.position_id', 'employees.join_date')
            ->join('employee_contracts', function ($join){
                $join->on('employees.id', 'employee_contracts.employee_id');
                $join->where('employee_contracts.status', 't');
            })->where('employees.id', $id)->first();

        $datas->positionName = $this->listMasters['EJP'][$datas->position_id];
        $datas->joinDate = setDate($datas->join_date, 't');

        return json_encode($datas);
    }
}
