<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\AttendanceRoster;
use App\Models\Attendance\AttendanceShift;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContract;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RosterController extends Controller
{

//    public function __construct()
//    {
//        \View::share([
//            'gender' => $this->gender,
//        ]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('employees as t1')
            ->select('t1.id', 't1.name', 't1.emp_number', 't3.name as shiftName', 't3.start', 't3.end', 't4.name as posName')
            ->join('employee_contracts as t2', function ($join){
                $join->on('t1.id', 't2.employee_id');
                $join->where('t2.status', 't');
            })
            ->join('attendance_shifts as t3', 't2.shift_id', 't3.id')
            ->join('app_masters as t4', 't2.position_id', 't4.id');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('t1.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t1.emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['rosters'] = $sql->paginate($this->defaultPagination($request));

        return view('attendances.rosters.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
//        dd($request->all());
        return redirect()->route('attendances.rosters.index');
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
    public function edit($id, Request $request)
    {
        $data['emp'] = Employee::find($id);
        $data['empc'] = EmployeeContract::select('position_id', 'shift_id')->where([
            ['employee_id', $id],
            ['status', 't']
        ])->first();
        $data['shift'] = AttendanceShift::find($data['empc']->shift_id);
        $data['masters'] = Master::where('category', 'EJP')->orderBy('id')->pluck('name','id')->toArray();
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['filterMonth'] = $request->get('filterMonth') ?? date('m');
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $data['totalDay'] = cal_days_in_month(CAL_GREGORIAN, $data['filterMonth'], $data['filterYear']);
        $data['test'] = defaultStatus();
        $data['rosters'] = AttendanceRoster::where('employee_id', $id)
            ->whereMonth('date', $data['filterMonth'])
            ->whereYear('date', $data['filterYear'])
            ->get();

        return view('attendances.rosters.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $month = $request->monthValue ?? date('m'); //GET SELECTED MONTH
        $year = $request->yearValue ?? date('Y'); //GET SELECTED YEAR
        $totalDay = cal_days_in_month(CAL_GREGORIAN, $month, $year); //GET TOTAL DAY FROM SELECTED MONTH AND YEAR

        AttendanceRoster::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->delete();
        for ($i = 1; $i<=$totalDay; $i++) {
            $day = $i <=10 ? "0".$i : $i;
            $date = implode("-", array($year, $month, $day));
            AttendanceRoster::create([
                'employee_id' => $id,
                'shift_id' => $request->shift_id_[$i],
                'date' => $date,
                'start' => $request->start_[$i],
                'end' => $request->end_[$i],
                'description' => $request->description_[$i],
            ]);
        }
        Alert::success('Success', 'Roster updated successfully');

        return redirect()->route('attendances.rosters.index');
    }

    public function getDetail($id){
        $datas = AttendanceShift::find($id);

        return json_encode($datas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
