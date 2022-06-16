<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\ShiftRequest;
use App\Models\Attendance\AttendanceShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{

    public function __construct()
    {
        \View::share([
            'status' => defaultStatus(),
            'yesorno' => array('f' => 'No', 't' => 'Yes'),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('attendance_shifts');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('code', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['shifts'] = $sql->paginate($this->defaultPagination($request));

        return view('attendances.shifts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendances.shifts.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        AttendanceShift::create([
            'name' => $request->name,
            'code' => $request->code,
            'start' => $request->start,
            'end' => $request->end,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'tolerance' => $request->tolerance,
            'night_shift' => $request->night_shift,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'success'=>'Shift inserted successfully',
            'url'=> route('attendances.shifts.index')
        ]);
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
        $shift = AttendanceShift::find($id);

        return view('attendances.shifts.form', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftRequest $request, $id)
    {
        $shift = AttendanceShift::find($id);
        $shift->name = $request->name;
        $shift->code = $request->code;
        $shift->start = $request->start;
        $shift->end = $request->end;
        $shift->break_start = $request->break_start;
        $shift->break_end = $request->break_end;
        $shift->tolerance = $request->tolerance;
        $shift->night_shift = $request->night_shift;
        $shift->description = $request->description;
        $shift->status = $request->status;
        $shift->save();

        return response()->json([
            'success'=>'Shift updated successfully',
            'url'=> route('attendances.shifts.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AttendanceShift::find($id)->delete();

        Alert::success('Success', 'Shift deleted successfully');

        return redirect()->back();
    }
}
