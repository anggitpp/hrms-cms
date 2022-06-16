<?php

namespace App\Http\Controllers\ESS;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Payroll\PayrollProcess;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filterMonth'] = $request->get('filterMonth') ?? date('m');
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $data['emp'] = Employee::with('contract', 'payroll')->find(Auth::user()->employee_id);
        $data['position'] = Master::find($data['emp']->contract->position_id)->name;
        $data['process'] = PayrollProcess::where('month', (int)$data['filterMonth'])->where('type_id', $data['emp']->payroll->payroll_id)
            ->where('year', $data['filterYear'])
            ->where('approved_status', 't')
            ->first();
        $employeeId = Auth::user()->employee_id;
        if($data['process']) {
            $data['allowances'] = DB::table('payroll_process_details as t1')
                ->select('t1.value', 't2.name')
                ->join('payroll_components as t2', 't1.component_id', 't2.id')
                ->where('t2.type', 't')
                ->where('t1.process_id', $data['process']->id)
                ->where('t1.employee_id', $employeeId)
                ->orderBy('t2.id')
                ->get();

            $data['deductions'] = DB::table('payroll_process_details as t1')
                ->select('t1.value', 't2.name')
                ->join('payroll_components as t2', 't1.component_id', 't2.id')
                ->where('t2.type', 'f')
                ->where('t1.process_id', $data['process']->id)
                ->where('t1.employee_id', $employeeId)
                ->orderBy('t2.id')
                ->get();

            $data['processId'] = $data['process']->id;
            $data['id'] = $employeeId;
        }

        return view('ess.payslip.index', $data);
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
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
