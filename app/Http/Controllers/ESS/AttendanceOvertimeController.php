<?php

namespace App\Http\Controllers\ESS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceOvertimeRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\MasterPlacement;
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
        //GET DATA PLACEMENT EMPLOYEE
        $data['placement'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();

        $employeeId = Auth::user()->employee_id;
        $data['emp'] = Employee::find($employeeId);

        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $sql = DB::table('attendance_overtimes as t1')
            ->select('t1.id', 't1.number', 't1.start_date', 't1.start_time', 't1.end_time', 't1.approved_status', 't2.name', 't2.emp_number')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->where('t1.employee_id', $employeeId)
            ->whereYear('t1.date', $data['filterYear']);
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter'])){
            $sql->where(function ($sql) use ($data) {
                $sql->where('t1.number', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.name', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['overtimes'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('ess.overtimes.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['emp'] = Employee::find(Auth::user()->employee_id);

        //GET LAST NUMBER
        $getLastNumber = AttendanceOvertime::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $data['overtimeNumber'] = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/SPL/'.date('Y');

        return !empty(access('create')) ? view('ess.overtimes.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceOvertimeRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            'izin_lembur_'.time(),
            $this->overtimePath);

        //CONDITION IF END TIME MORE THAN START TIME, THEN ADD 1 DAYS TO END DATE
        $startDate = Carbon::parse(resetDate($request->start_date));
        $endDate = resetDate($request->start_date);
        if($request->start_time > $request->end_time)
            $endDate = $startDate->addDays(1)->toDateString();

        //SET DATE AND TIME TO GET DIFF TIME
        $startDateTime = Carbon::parse(resetDate($request->start_date). " ".$request->start_time);
        $endDateTime = Carbon::parse($endDate. " ".$request->end_time);
        $request->duration = $endDateTime->diff($startDateTime)->format('%H:%I');

        AttendanceOvertime::create([
            'employee_id' => $request->employee_id,
            'number' => $request->number,
            'date' => resetDate($request->date),
            'start_date' => resetDate($request->start_date),
            'end_date' => $endDate,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'description' => $request->description,
            'filename' => $filename,
            'approved_status' => 'p',
        ]);

        Alert::success('Success', 'Data pengajuan lembur berhasil disimpan');

        return redirect()->route('ess.overtimes.index');
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
        //GET DETAIL OVERTIME
        $data['overtime'] = AttendanceOvertime::find($id);

        //GET DATA EMPLOYEES FOR SELECT EMPLOYEE
        $data['employees'] = Employee::active($data['overtime']->employee_id)->select(DB::raw("CONCAT(emp_number ,' - ', name) as name "), 'id')
            ->pluck('name', 'id')
            ->toArray();

        //GET DETAIL EMPLOYEE SELECTED
        $data['emp'] = Employee::find($data['overtime']->employee_id);

        return !empty(access('edit')) ? view('ess.overtimes.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceOvertimeRequest $request, $id)
    {
        $overtime = AttendanceOvertime::find($id);

        $filename = $request->exist_filename ? $overtime->filename : '';
        if($overtime->filename && $filename == '')
            \Storage::disk('public')->delete($overtime->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($overtime->filename);
            $filename = uploadFile($request->file('filename'), 'izin lembur_'.time(), $this->overtimePath);
        }

        //CONDITION IF END TIME MORE THAN START TIME, THEN ADD 1 DAYS TO END DATE
        $startDate = Carbon::parse(resetDate($request->start_date));
        $endDate = resetDate($request->start_date);
        if($request->start_time > $request->end_time)
            $endDate = $startDate->addDays(1)->toDateString();

        //SET DATE AND TIME TO GET DIFF TIME
        $startDateTime = Carbon::parse(resetDate($request->start_date). " ".$request->start_time);
        $endDateTime = Carbon::parse($endDate. " ".$request->end_time);
        $request->duration = $endDateTime->diff($startDateTime)->format('%H:%I');

        $overtime->employee_id = $request->employee_id;
        $overtime->number = $request->number;
        $overtime->date = resetDate($request->date);
        $overtime->start_date = resetDate($request->start_date);
        $overtime->end_date = $endDate;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->duration = $request->duration;
        $overtime->description = $request->description;
        $overtime->filename = $filename;
        $overtime->save();

        Alert::success('Success', 'Data pengajuan lembur berhasil disimpan');

        return redirect()->route('ess.overtimes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

    public function getEmployeeDetails($id){
        $datas = DB::table('employees')
            ->select('employee_contracts.position_id', 'employee_contracts.rank_id')
            ->join('employee_contracts', function ($join){
                $join->on('employees.id', 'employee_contracts.employee_id');
                $join->where('employee_contracts.status', 't');
            })->where('employees.id', $id)->first();

        $datas->positionName = $this->listMasters['EJP'][$datas->position_id];
        $datas->rankName = $this->listMasters['EP'][$datas->rank_id];

        return json_encode($datas);
    }
}
