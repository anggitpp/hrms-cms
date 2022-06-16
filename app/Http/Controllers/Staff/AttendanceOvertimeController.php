<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceOvertimeRequest;
use App\Models\Employee\Employee;
use App\Models\ESS\AttendanceOvertime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceOvertimeController extends Controller
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
        $this->overtimePath = '/uploads/ess/overtime/';

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
        $sql = DB::table('attendance_overtimes as t1')
            ->select('t1.id', 't1.number', 't1.start_date', 't1.start_time', 't1.end_time', 't1.approved_status', 't2.name', 't2.emp_number')
            ->join('employees as t2', 't1.employee_id', 't2.id');

        //CHECK IF AUTH USER HAVE SUPER ACCESS TO VIEW ALL DATA AND APPROVE ALL DATA, IF NOT, THEN EXECUTE THIS QUERY
        if (empty(access('superAccess'))) {
            $employeeId = Auth::user()->employee_id;
            $sql->join('employee_contracts as t3', function ($join) {
                $join->on('t2.id', 't3.employee_id');
                $join->where('t3.status', 't');
            })->join('employee_master_placements as t4', 't3.placement_id', 't4.id')
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
                    ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['overtimes'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('staff.overtimes.index', $data) : abort(401);
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

        //GET LAST NUMBER
        $getLastNumber = AttendanceOvertime::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $data['overtimeNumber'] = Str::padLeft(intval(Str::substr($getLastNumber, 0, 4)) + 1, '4', '0') . '/' . numToRoman(date('m')) . '/SPL/' . date('Y');

        return !empty(access('create')) ? view('staff.overtimes.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceOvertimeRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            'izin_lembur_' . time(),
            $this->overtimePath);

        //CONDITION IF END TIME MORE THAN START TIME, THEN ADD 1 DAYS TO END DATE
        $startDate = Carbon::parse(resetDate($request->start_date));
        $endDate = resetDate($request->start_date);
        if ($request->start_time > $request->end_time)
            $endDate = $startDate->addDays(1)->toDateString();

        AttendanceOvertime::create([
            'employee_id' => $request->employee_id,
            'number' => $request->number,
            'date' => resetDate($request->date),
            'start_date' => resetDate($request->start_date),
            'end_date' => $endDate,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'filename' => $filename,
            'approved_status' => 'p',
        ]);

        Alert::success('Success', 'Data pengajuan lembur berhasil disimpan');

        return redirect()->route('staff.overtimes.index');
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
        //GET DETAIL OVERTIME
        $data['overtime'] = AttendanceOvertime::find($id);

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
            ->orWhere('t1.id', $data['overtime']->employee_id)
            ->pluck('t1.name', 't1.id')->toArray();

        //GET DETAIL EMPLOYEE SELECTED
        $data['emp'] = Employee::find($data['overtime']->employee_id);

        return !empty(access('edit')) ? view('staff.overtimes.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceOvertimeRequest $request, $id)
    {
        $overtime = AttendanceOvertime::find($id);

        $filename = $overtime->filename;
        if ($request->file('filename')) {
            Storage::disk('public')->delete($overtime->filename);
            $filename = uploadFile($request->file('filename'), Str::slug('izin lembur') . '_' . time(), $this->overtimePath);
        }

        //CONDITION IF END TIME MORE THAN START TIME, THEN ADD 1 DAYS TO END DATE
        $startDate = Carbon::parse(resetDate($request->start_date));
        $endDate = resetDate($request->start_date);
        if ($request->start_time > $request->end_time)
            $endDate = $startDate->addDays(1)->toDateString();

        $overtime->employee_id = $request->employee_id;
        $overtime->number = $request->number;
        $overtime->date = resetDate($request->date);
        $overtime->start_date = resetDate($request->start_date);
        $overtime->end_date = $endDate;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->description = $request->description;
        $overtime->filename = $filename;
        $overtime->save();

        Alert::success('Success', 'Data pengajuan lembur berhasil disimpan');

        return redirect()->route('staff.overtimes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $overtime = AttendanceOvertime::find($id);
        Storage::disk('public')->delete($overtime->filename);
        $overtime->delete();

        Alert::success('Success', 'Data Pengajuan Lembur berhasil dihapus');

        return redirect()->back();
    }

    public function approveEdit($id)
    {
        $data['id'] = $id;
        $data['overtime'] = AttendanceOvertime::find($id);
        $data['emp'] = Employee::find($data['overtime']->employee_id);

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
            ->orWhere('t1.id', $data['overtime']->employee_id)
            ->pluck('t1.name', 't1.id')->toArray();

        return view('staff.overtimes.form', $data);
    }

    public function approveUpdate(Request $request, $id)
    {
        $overtime = AttendanceOvertime::find($id);
        $overtime->approved_by = \Auth::user()->id;
        $overtime->approved_date = resetDate($request->approved_date);
        $overtime->approved_status = $request->approved_status;
        $overtime->approved_note = $request->approved_note;
        $overtime->save();

        Alert::success('Success', 'Data pengajuan lembur berhasil diapprove');

        return redirect()->route('staff.overtimes.index');
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
