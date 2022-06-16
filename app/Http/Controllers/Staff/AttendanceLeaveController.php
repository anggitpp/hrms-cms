<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceLeaveRequest;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendanceLeave;
use App\Models\ESS\AttendanceLeaveMaster;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceLeaveController extends Controller
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
        $this->leavePath = '/uploads/ess/leave/';

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
        $sql = DB::table('attendance_leaves as t1')
            ->select('t1.id', 't1.number', 't1.start_date', 't1.end_date', 't1.approved_status', 't2.name', 't2.emp_number',
                't3.name as namaCuti')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('attendance_leave_masters as t3', 't1.type_id', 't3.id');

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

        //FILTER YEAR DATA
        $sql->whereYear('t1.date', $data['filterYear']);

        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter'])) {
            $sql->where(function ($sql) use ($data) {
                $sql->where('t1.number', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.name', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                    ->orWhere('t3.name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['leaves'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('staff.leaves.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now()->toDateString();

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

        $data['leaves'] = AttendanceLeaveMaster::select('id', 'name')
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->pluck('name', 'id')->toArray();

        //GET LAST NUMBER
        $getLastNumber = AttendanceLeave::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $data['leaveNumber'] = Str::padLeft(intval(Str::substr($getLastNumber, 0, 4)) + 1, '4', '0') . '/' . numToRoman(date('m')) . '/IC/' . date('Y');

        return !empty(access('create')) ? view('staff.leaves.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceLeaveRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')) . '_' . time(),
            $this->leavePath);

        AttendanceLeave::create([
            'employee_id' => $request->employee_id,
            'number' => $request->number,
            'date' => resetDate($request->date),
            'type_id' => $request->type_id,
            'quota' => $request->quota,
            'start_date' => resetDate($request->start_date),
            'end_date' => resetDate($request->end_date),
            'amount' => $request->amount,
            'remaining' => $request->remaining,
            'filename' => $filename,
            'description' => $request->description,
            'approved_status' => 'p',
        ]);

        Alert::success('Success', 'Data pengajuan cuti berhasil disimpan');

        return redirect()->route('staff.leaves.index');
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
        $now = Carbon::now()->toDateString();
        $data['id'] = $id;
        $data['leave'] = AttendanceLeave::find($id);
        $data['emp'] = Employee::find($data['leave']->employee_id);

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
            ->orWhere('t1.id', $data['leave']->employee_id)
            ->pluck('t1.name', 't1.id')->toArray();

        $data['leaves'] = AttendanceLeaveMaster::select('id', 'name')
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->orWhere('id', $data['leave']->type_id)
            ->pluck('name', 'id')->toArray();

        return !empty(access('edit')) ? view('staff.leaves.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceLeaveRequest $request, $id)
    {
        $leave = AttendanceLeave::find($id);
        $filename = $leave->filename;
        if ($request->file('filename')) {
            Storage::disk('public')->delete($leave->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')) . '_' . time(), $this->leavePath);
        }
        $leave->employee_id = $request->employee_id;
        $leave->date = resetDate($request->date);
        $leave->type_id = $request->type_id;
        $leave->quota = $request->quota;
        $leave->start_date = resetDate($request->start_date);
        $leave->end_date = resetDate($request->end_date);
        $leave->amount = $request->amount;
        $leave->remaining = $request->remaining;
        $leave->filename = $filename;
        $leave->description = $request->description;
        $leave->save();

        Alert::success('Success', 'Data pengajuan cuti berhasil disimpan');

        return redirect()->route('staff.leaves.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = AttendanceLeave::find($id);
        Storage::disk('public')->delete($leave->filename);
        $leave->delete();

        Alert::success('Success', 'Data Pengajuan Cuti berhasil dihapus');

        return redirect()->back();
    }

    public function approveEdit($id)
    {
        $now = Carbon::now()->toDateString();
        $data['id'] = $id;
        $data['leave'] = AttendanceLeave::find($id);
        $data['emp'] = Employee::find($data['leave']->employee_id);

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
            ->orWhere('t1.id', $data['leave']->employee_id)
            ->pluck('t1.name', 't1.id')->toArray();

        $data['leaves'] = AttendanceLeaveMaster::select('id', 'name')
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->orWhere('id', $data['leave']->type_id)
            ->pluck('name', 'id')->toArray();

        return !empty(access('approve/edit')) ? view('staff.leaves.form', $data) : abort(401);
    }

    public function approveUpdate(Request $request, $id)
    {
        $leave = AttendanceLeave::find($id);
        $leave->approved_by = \Auth::user()->id;
        $leave->approved_date = resetDate($request->approved_date);
        $leave->approved_status = $request->approved_status;
        $leave->approved_note = $request->approved_note;
        $leave->save();

        Alert::success('Success', 'Data pengajuan cuti berhasil diapprove');

        return redirect()->route('staff.leaves.index');
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

    public function getLeaveDetails($id, $employeeId)
    {
        //GET DATA EMPLOYEE FROM SELECTED EMPLOYEE
        $emp = Employee::find($employeeId);

        //GET DATA FROM LEAVE APPLIED BY SELECTED EMPLOYEE AND SELECTED TYPE
        $dataApplied = AttendanceLeave::where('type_id', $id)
            ->where('employee_id', $employeeId);
        if ($_GET['mode'] == 'edit')
            $dataApplied->where('id', '!=', $_GET['id']);

        $amountApplied = $dataApplied->sum('amount') ?? 0;

        //GET DATA LEAVE FROM SELECTED TYPE
        $leave = AttendanceLeaveMaster::find($id);
        $leaveQuota = $leave->value('quota');

        //CHECK IF GENDER IS NOT ALL THEN CHECK EMPLOYEE GENDER, IF NOT EQUAL MAKE ALL ZERO
        if ($leave->gender != 'a' && $leave->gender != $emp->gender) {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = '';

            return json_encode($data);
        }

        //GET MONTH DIFFERENCE FROM NOW AND JOIN DATE
        $diffMonth = Carbon::parse($emp->join_date)->diffInMonths(Carbon::now());

        //CHECK IF WOKRING LIFE REQUIREMENT LEAVE IS LESS THAN WORKING LIFE EMPLOYEE, IF NOT THEN MAKE IT ALL ZERO
        if ($leave->working_life >= $diffMonth) {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = '';

            return json_encode($data);
        }

        //CHECK IF LOCATION IS NOT 'SEMUA LOKASI' THEN CHECK IF LOCATION REQUIREMENT IS EQUAL WITH EMPLOYEE LOCATION, IF NOT MAKE IT ALL ZERO
        if ($leave->location_id && $leave->location_id != $emp->contract->location_id) {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = '';

            return json_encode($data);
        }

        //GET REMAINING QUOTA FROM QUOTA - AMOUNT APPLIED
        $remaining = $leaveQuota - $amountApplied;

        $data['quota'] = $remaining;
        $data['amount'] = 0;
        $data['remaining'] = $remaining;

        //PARSE DATE TO CARBON FORMAT
        if ($_GET['startDate'] && $_GET['endDate']) {
            $startDate = Carbon::createFromFormat('d/m/Y', $_GET['startDate']);
            $endDate = Carbon::createFromFormat('d/m/Y', $_GET['endDate']);

            //GET DIFF DAYS THEN + 1, CAUSE SAMEDAY COUNTED 1
            $diffDays = ($startDate->diffInDays($endDate)) + 1;

            //GET PERIOD BETWEEN TWO DATES
            $period = CarbonPeriod::create($startDate, $endDate);

            // Iterate over the period
            foreach ($period as $date) {
                $arrDateList[] = $date->format('Y-m-d');
            }

            //CHECK IF ANY WEEKEND THEN ++
            $weekend = 0;
            foreach ($arrDateList as $key) {
                $cekDay = date('w', strtotime($key));
                if ($cekDay == 0 || $cekDay == 6) {
                    $weekend++;
                }
            }

            $data['quota'] = $remaining;
            $data['amount'] = $diffDays - $weekend;
            $data['remaining'] = $remaining - $data['amount'];
        }

        return json_encode($data);
    }
}
