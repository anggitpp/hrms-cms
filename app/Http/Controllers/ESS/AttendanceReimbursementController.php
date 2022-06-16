<?php

namespace App\Http\Controllers\ESS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ESS\AttendanceReimbursementRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\MasterPlacement;
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
            ->select('id', 'name','category')
            ->whereIn('category', [
                'ESSKR',
                'EJP',
                'ETP',
                'EP',
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
        //GET DATA PLACEMENT EMPLOYEE
        $data['placement'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();

        $employeeId = Auth::user()->employee_id;
        $data['emp'] = Employee::find($employeeId);

        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $sql = DB::table('attendance_reimbursements as t1')
            ->select('t1.id', 't1.number', 't1.date', 't1.value', 't1.description', 't1.approved_status', 't2.name', 't2.emp_number',
                't3.name as categoryName')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('app_masters as t3', function ($join){
                $join->on('t1.category_id', 't3.id');
                $join->where('t3.category', 'ESSKR');
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
        $data['reimbursements'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('ess.reimbursements.index', $data) : abort(401);
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
            ->where('category', 'ESSKR')
            ->pluck('name', 'id')->toArray();

        //GET LAST NUMBER
        $getLastNumber = AttendanceReimbursement::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('number', 'desc')
                ->pluck('number')
                ->first() ?? 0;

        //SET FORMAT FOR NUMBER LEAVE
        $data['reimbursementNumber'] = Str::padLeft(intval(Str::substr($getLastNumber,0,4)) + 1, '4', '0').'/'.numToRoman(date('m')).'/RM/'.date('Y');

        return !empty(access('create')) ? view('ess.reimbursements.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceReimbursementRequest $request)
    {
        $emp = Employee::find(Auth::user()->employee_id);
        $filename = uploadFile(
            $request->file('filename'),
            $emp->name.'_'.time(),
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

        return redirect()->route('ess.reimbursements.index');
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
        $data['reimbursement'] = AttendanceReimbursement::find($id);

        $data['emp'] = Employee::find($data['reimbursement']->employee_id);

        //GET DATA MASTER CATEGORIES ACTIVE OR ITSELF
        $data['categories'] = Master::select('id', 'name')
            ->active($data['reimbursement']->category_id)
            ->where('category', 'ESSKR')
            ->pluck('name', 'id')->toArray();

        return !empty(access('edit')) ? view('ess.reimbursements.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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

        return redirect()->route('ess.reimbursements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reimbursement = AttendanceReimbursement::find($id);
        Storage::disk('public')->delete($reimbursement->filename);
        $reimbursement->delete();

        Alert::success('Success', 'Data Pengajuan reimbursement berhasil dihapus');

        return redirect()->back();
    }
}
