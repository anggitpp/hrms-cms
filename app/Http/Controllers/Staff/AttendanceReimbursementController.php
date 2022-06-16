<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceReimbursementRequest;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendanceReimbursement;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceReimbursementController extends Controller
{
    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name', 'category')
            ->whereIn('category', [
                'EJP',
                'EP',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value) {
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }
        $this->reimbursementPath = '/uploads/ess/reimbursement/';

        \View::share([
            'masters' => $masters,
            'approveStatus' => defaultStatusApproval()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $sql = DB::table('attendance_reimbursements as t1')
            ->select('t1.id', 't1.number', 't1.date', 't1.value', 't1.approved_status', 't2.name', 't2.emp_number',
                't3.name as categoryName')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('app_masters as t3', function ($join) {
                $join->on('t1.category_id', 't3.id');
                $join->where('t3.category', 'ESSKR');
            });

        //CHECK IF AUTH USER HAVE SUPER ACCESS TO VIEW ALL DATA AND APPROVE ALL DATA, IF NOT, THEN EXECUTE THIS QUERY
        if (empty(access('superAccess'))) {
            $employeeId = Auth::user()->employee_id;
            $sql->join('employee_contracts as t4', function ($join) {
                $join->on('t2.id', 't4.employee_id');
                $join->where('t4.status', 't');
            })->join('employee_master_placements as t5', 't4.placement_id', 't5.id')
                ->where(function ($sql) use ($employeeId) {
                    $sql->where('leader_id', $employeeId)
                        ->orWhere('administration_id', $employeeId)
                        ->orWhere('t1.employee_id', $employeeId);
                });
        }

        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter'])) {
            $sql->where(function ($sql) use ($data) {
                $sql->where('t1.number', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.name', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                    ->orWhere('t3.name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['reimbursements'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('staff.reimbursements.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $queryEmployee = DB::table('employees as t1')->select(DB::raw("CONCAT(t1.emp_number ,' - ', t1.name) as name"), 't1.id');

        //CHECK IF AUTH USER HAVE SUPER ACCESS TO VIEW ALL DATA AND APPROVE ALL DATA, IF NOT, THEN EXECUTE THIS QUERY
        if (empty(access('superAccess'))) {
            $employeeId = Auth::user()->employee_id;
            $queryEmployee->join('employee_contracts as t2', function ($join) {
                $join->on('t1.id', 't2.employee_id');
                $join->where('t2.status', 't');
            })
                ->join('employee_master_placements as t3', 't2.placement_id', 't3.id')
                ->where(function ($sql) use ($employeeId) {
                    $sql->where('leader_id', $employeeId)
                        ->orWhere('administration_id', $employeeId)
                        ->orWhere('t1.id', $employeeId);
                });
        }

        $data['employees'] = $queryEmployee->where('t1.status_id', $this->getParameter('SA'))->pluck('t1.name', 't1.id')->toArray();

        $data['categories'] = Master::select('id', 'name')
            ->active()
            ->where('category', 'ESSKR')
            ->pluck('name', 'id')->toArray();

        //GET LAST NUMBER
        $getLastNumber = AttendanceReimbursement::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $data['reimbursementNumber'] = Str::padLeft(intval(Str::substr($getLastNumber, 0, 4)) + 1, '4', '0') . '/' . numToRoman(date('m')) . '/RM/' . date('Y');

        return !empty(access('create')) ? view('staff.reimbursements.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceReimbursementRequest $request)
    {
        $emp = Employee::find($request->employee_id);
        $filename = uploadFile(
            $request->file('filename'),
            $emp->name . '_' . time(),
            $this->reimbursementPath);

        AttendanceReimbursement::create([
            'number' => $request->number,
            'date' => resetDate($request->date),
            'employee_id' => $request->employee_id,
            'category_id' => $request->category_id,
            'value' => resetCurrency($request->value),
            'description' => $request->description,
            'filename' => $filename,
            'approved_status' => 'p',
        ]);

        Alert::success('Success', 'Data pengajuan reimbursement berhasil disimpan');

        return redirect()->route('staff.reimbursements.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET DATA REIMBURSEMENT
        $data['reimbursement'] = AttendanceReimbursement::find($id);

        //GET DATA EMPLOYEES FOR SELECT EMPLOYEE
        $queryEmployee = DB::table('employees as t1')->select(DB::raw("CONCAT(t1.emp_number ,' - ', t1.name) as name"), 't1.id');

        //CHECK IF AUTH USER HAVE SUPER ACCESS TO VIEW ALL DATA AND APPROVE ALL DATA, IF NOT, THEN EXECUTE THIS QUERY
        if (empty(access('superAccess'))) {
            $employeeId = Auth::user()->employee_id;
            $queryEmployee->join('employee_contracts as t2', function ($join) {
                $join->on('t1.id', 't2.employee_id');
                $join->where('t2.status', 't');
            })
                ->join('employee_master_placements as t3', 't2.placement_id', 't3.id')
                ->where(function ($sql) use ($employeeId) {
                    $sql->where('leader_id', $employeeId)
                        ->orWhere('administration_id', $employeeId)
                        ->orWhere('t1.id', $employeeId);
                });
        }

        $data['employees'] = $queryEmployee->where('t1.status_id', $this->getParameter('SA'))
            ->orWhere('t1.id', $data['reimbursement']->employee_id)
            ->pluck('t1.name', 't1.id')->toArray();

        $data['emp'] = Employee::find($data['reimbursement']->employee_id);

        //GET DATA MASTER CATEGORIES ACTIVE OR ITSELF
        $data['categories'] = Master::select('id', 'name')
            ->active($data['reimbursement']->category_id)
            ->where('category', 'ESSKR')
            ->pluck('name', 'id')->toArray();

        return !empty(access('edit')) ? view('staff.reimbursements.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceReimbursementRequest $request, $id)
    {
        $emp = Employee::find(Auth::user()->employee_id);
        $reimbursement = AttendanceReimbursement::find($id);
        $filename = $request->exist_filename ? $reimbursement->filename : '';
        if($reimbursement->filename && $filename == '')
            \Storage::disk('public')->delete($reimbursement->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($reimbursement->filename);
            $filename = uploadFile($request->file('filename'), $emp->name.'_'.time(), $this->reimbursementPath);
        }

        $reimbursement->number = $request->number;
        $reimbursement->date = resetDate($request->date);
        $reimbursement->employee_id = $request->employee_id;
        $reimbursement->category_id = $request->category_id;
        $reimbursement->value = resetCurrency($request->value);
        $reimbursement->description = $request->description;
        $reimbursement->filename = $filename;
        $reimbursement->save();

        Alert::success('Success', 'Data pengajuan reimbursement berhasil disimpan');

        return redirect()->route('staff.reimbursements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reimbursement = AttendanceReimbursement::find($id);
        Storage::disk('public')->delete($reimbursement->filename);
        $reimbursement->delete();

        Alert::success('Success', 'Data Pengajuan Reimbursement berhasil dihapus');

        return redirect()->back();
    }

    public function approveEdit($id)
    {
        $data['id'] = $id;
        $data['reimbursement'] = AttendanceReimbursement::find($id);
        $data['emp'] = Employee::find($data['reimbursement']->employee_id);

        //GET DATA EMPLOYEES
        $queryEmployee = DB::table('employees as t1')->select(DB::raw("CONCAT(t1.emp_number ,' - ', t1.name) as name"), 't1.id');

        //CHECK IF AUTH USER HAVE SUPER ACCESS TO VIEW ALL DATA AND APPROVE ALL DATA, IF NOT, THEN EXECUTE THIS QUERY
        if (empty(access('superAccess'))) {
            $employeeId = Auth::user()->employee_id;
            $queryEmployee->join('employee_contracts as t2', function ($join) {
                $join->on('t1.id', 't2.employee_id');
                $join->where('t2.status', 't');
            })
                ->join('employee_master_placements as t3', 't2.placement_id', 't3.id')
                ->where(function ($sql) use ($employeeId) {
                    $sql->where('leader_id', $employeeId)
                        ->orWhere('administration_id', $employeeId)
                        ->orWhere('t1.id', $employeeId);
                });
        }

        $data['employees'] = $queryEmployee->where('t1.status_id', $this->getParameter('SA'))
            ->orWhere('t1.id', $data['reimbursement']->employee_id)
            ->pluck('t1.name', 't1.id')->toArray();
        //GET DATA MASTER CATEGORIES ACTIVE OR ITSELF
        $data['categories'] = Master::select('id', 'name')
            ->active($data['reimbursement']->category_id)
            ->where('category', 'ESSKR')
            ->pluck('name', 'id')->toArray();

        return view('staff.reimbursements.form', $data);
    }

    public function approveUpdate(Request $request, $id)
    {
        $reimbursement = AttendanceReimbursement::find($id);
        $reimbursement->approved_by = \Auth::user()->id;
        $reimbursement->approved_date = resetDate($request->approved_date);
        $reimbursement->approved_status = $request->approved_status;
        $reimbursement->approved_note = $request->approved_note;
        $reimbursement->save();

        Alert::success('Success', 'Data pengajuan reimbursement berhasil diapprove');

        return redirect()->route('staff.reimbursements.index');
    }

    public function getEmployeeDetails($id)
    {
        $datas = DB::table('employees')
            ->select('employee_contracts.position_id', 'employee_contracts.rank_id')
            ->join('employee_contracts', function ($join) {
                $join->on('employees.id', 'employee_contracts.employee_id');
                $join->where('employee_contracts.status', 't');
            })->where('employees.id', $id)->first();

        $datas->positionName = $this->listMasters['EJP'][$datas->position_id];
        $datas->rankName = $this->listMasters['EP'][$datas->rank_id];

        return json_encode($datas);
    }
}
