<?php

namespace App\Http\Controllers\ESS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendancePermissionRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\MasterPlacement;
use App\Models\ESS\AttendancePermission;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AttendancePermissionController extends Controller
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
        $this->permissionPath = '/uploads/ess/permission/';

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
        $sql = DB::table('attendance_permissions as t1')
            ->select('t1.id', 't1.number', 't1.start_date', 't1.end_date', 't1.approved_status', 't2.name', 't2.emp_number',
                't3.name as categoryName')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('app_masters as t3', function ($join){
                $join->on('t1.category_id', 't3.id');
                $join->where('t3.category', 'ESSKI');
            })
            ->where('t1.employee_id', $employeeId)
            ->whereYear('t1.date', $data['filterYear']);
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter'])){
            $sql->where(function ($sql) use ($data) {
                $sql->where('t1.number', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.name', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                    ->orWhere('t3.name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['permissions'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('ess.permissions.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['emp'] = Employee::find(Auth::user()->employee_id);
        $data['categories'] = Master::select('id', 'name')
            ->active()
            ->where('category', 'ESSKI')
            ->pluck('name', 'id')->toArray();

        //GET LAST NUMBER
        $getLastNumber = AttendancePermission::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $data['permissionNumber'] = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/IK/'.date('Y');

        return !empty(access('create')) ? view('ess.permissions.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendancePermissionRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug('izin ketidakhadiran').'_'.time(),
            $this->permissionPath);

        AttendancePermission::create([
            'number' => $request->number,
            'date' => resetDate($request->date),
            'employee_id' => $request->employee_id,
            'category_id' => $request->category_id,
            'start_date' => resetDate($request->start_date),
            'end_date' => resetDate($request->end_date),
            'description' => $request->description,
            'filename' => $filename,
            'approved_status' => 'p',
        ]);

        Alert::success('Success', 'Data pengajuan izin berhasil disimpan');

        return redirect()->route('ess.permissions.index');
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
        //GET DATA PERMISSION
        $data['permission'] = AttendancePermission::find($id);

        $data['emp'] = Employee::find($data['permission']->employee_id);

        //GET DATA MASTER CATEGORIES ACTIVE OR ITSELF
        $data['categories'] = Master::select('id', 'name')
            ->active($data['permission']->category_id)
            ->where('category', 'ESSKI')
            ->pluck('name', 'id')->toArray();

        return !empty(access('edit')) ? view('ess.permissions.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendancePermissionRequest $request, $id)
    {
        $permission = AttendancePermission::find($id);
        $filename = $permission->filename;
        if($request->file('filename')){
            Storage::disk('public')->delete($permission->filename);
            $filename = uploadFile($request->file('filename'), Str::slug('izin ketidakhadiran').'_'.time(), $this->permissionPath);
        }
        $permission->number = $request->number;
        $permission->date = resetDate($request->date);
        $permission->employee_id = $request->employee_id;
        $permission->category_id = $request->category_id;
        $permission->start_date = resetDate($request->start_date);
        $permission->end_date = resetDate($request->end_date);
        $permission->description = $request->description;
        $permission->filename = $filename;
        $permission->save();

        Alert::success('Success', 'Data pengajuan izin berhasil disimpan');

        return redirect()->route('ess.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = AttendancePermission::find($id);
        Storage::disk('public')->delete($permission->filename);
        $permission->delete();

        Alert::success('Success', 'Data Pengajuan Izin berhasil dihapus');

        return redirect()->back();
    }
}
