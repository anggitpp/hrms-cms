<?php

namespace App\Http\Controllers\ESS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceLeaveRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\MasterPlacement;
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
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'EP',
                'ETP',
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
        $this->leavePath = '/uploads/ess/leave/';

        \View::share([
            'masters' => $masters,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //GET DATA PLACEMENT EMPLOYEE
        $data['placement'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();

        $employeeId = Auth::user()->employee_id;
        $data['emp'] = Employee::find($employeeId);
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $sql = DB::table('attendance_leaves as t1')
            ->select('t1.id', 't1.number', 't1.start_date', 't1.end_date', 't1.approved_status', 't2.name', 't2.emp_number',
                't3.name as namaCuti')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('attendance_leave_masters as t3','t1.type_id', 't3.id')
            ->where('t1.employee_id', $employeeId)
            ->whereYear('t1.date', $data['filterYear']);

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

        return view('ess.leaves.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now()->toDateString();

        $data['emp'] = Employee::find(Auth::user()->employee_id);
        $data['leaves'] = AttendanceLeaveMaster::select('id', 'name')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->pluck('name', 'id')->toArray();

        //GET LAST NUMBER
        $getLastNumber = AttendanceLeave::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;
        //SET FORMAT FOR NUMBER LEAVE
        $data['leaveNumber'] = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/IC/'.date('Y');

        return view('ess.leaves.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceLeaveRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
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

        return redirect()->route('ess.leaves.index');
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
        $now = Carbon::now()->toDateString();
        $data['id'] = $id;
        $data['leave'] = AttendanceLeave::find($id);
        $data['emp'] = Employee::find($data['leave']->employee_id);

        $data['leaves'] = AttendanceLeaveMaster::select('id', 'name')
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->orWhere('id', $data['leave']->type_id)
            ->pluck('name', 'id')->toArray();

        return view('ess.leaves.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceLeaveRequest $request, $id)
    {
        $leave = AttendanceLeave::find($id);
        $filename = $leave->filename;
        if($request->file('filename')){
            Storage::disk('public')->delete($leave->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->leavePath  );
        }
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

        return redirect()->route('ess.leaves.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

    public function getLeaveDetails($id, $employeeId)
    {
        //GET DATA EMPLOYEE FROM SELECTED EMPLOYEE
        $emp = Employee::find($employeeId);

        //GET DATA FROM LEAVE APPLIED BY SELECTED EMPLOYEE AND SELECTED TYPE
        $dataApplied = AttendanceLeave::where('type_id', $id)
            ->where('employee_id', $employeeId);
        if($_GET['mode'] == 'edit')
            $dataApplied->where('id', '!=', $_GET['id']);

        $amountApplied = $dataApplied->sum('amount') ?? 0;

        //GET DATA LEAVE FROM SELECTED TYPE
        $leave = AttendanceLeaveMaster::find($id);
        $leaveQuota = $leave->value('quota');

        //CHECK IF GENDER IS NOT ALL THEN CHECK EMPLOYEE GENDER, IF NOT EQUAL MAKE ALL ZERO
        if($leave->gender != 'a' && $leave->gender != $emp->gender)
        {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = '';

            return json_encode($data);
        }

        //GET MONTH DIFFERENCE FROM NOW AND JOIN DATE
        $diffMonth = Carbon::parse($emp->join_date)->diffInMonths(Carbon::now());

        //CHECK IF WOKRING LIFE REQUIREMENT LEAVE IS LESS THAN WORKING LIFE EMPLOYEE, IF NOT THEN MAKE IT ALL ZERO
        if($leave->working_life >= $diffMonth)
        {
            $data['quota'] = 0;
            $data['amount'] = 0;
            $data['remaining'] = '';

            return json_encode($data);
        }

        //CHECK IF LOCATION IS NOT 'SEMUA LOKASI' THEN CHECK IF LOCATION REQUIREMENT IS EQUAL WITH EMPLOYEE LOCATION, IF NOT MAKE IT ALL ZERO
        if($leave->location_id && $leave->location_id != $emp->contract->location_id)
        {
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
        if($_GET['startDate'] && $_GET['endDate']){
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
