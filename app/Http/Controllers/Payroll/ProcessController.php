<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Payroll\PayrollComponent;
use App\Models\Payroll\PayrollProcess;
use App\Models\Payroll\PayrollProcessDetail;
use App\Models\Payroll\PayrollType;
use App\Models\Setting\Master;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['types'] = PayrollType::where('status', 't')->pluck('name', 'id')->toArray();
        $data['filterType'] = $request->get('filterType') ?? array_key_first($data['types']);
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');

        return !empty(access('index')) ? view('payrolls.process.index', $data) : abort(401);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $typeId, $month, $year)
    {
        $data['process'] = PayrollProcess::where('type_id', $typeId)->where('month', $month)->where('year', $year)->first();
        $data['filter'] = $request->get('filter') ?? '';
        $sql = DB::table('payroll_processes as t1')
            ->select('t1.id as processId', 't3.id as id', 't3.name', 't3.emp_number', DB::raw('SUM(t2.value) as value'))
            ->join('payroll_process_details as t2', 't1.id', 't2.process_id')
            ->join('employees as t3', 't2.employee_id', 't3.id')
            ->where('t1.type_id', $typeId)
            ->where('t1.month', $month)
            ->where('t1.year', $year);
        if (!empty($data['filter'])) {
            $sql->where(function ($sql) use ($data) {
                $sql->where('t3.name', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('t3.emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['details'] = $sql->groupBy('t2.employee_id')->paginate($this->defaultPagination($request));
        $data['month'] = $month;
        $data['year'] = $year;
        $data['typeId'] = $typeId;

        return view('payrolls.process.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($typeId, $month, $year)
    {
        $employees = DB::table('employees as t1')->join('employee_contracts as t2', function ($join) {
            $join->on('t1.id', 't2.employee_id');
            $join->where('t2.status', 't');
        })
            ->join('employee_payrolls as t3', 't1.id', 't3.employee_id')
            ->select('t1.id', 't2.rank_id', 't3.payroll_id')
            ->where('t1.status_id', $this->getParameter('SA'))
            ->where('t3.payroll_id', $typeId)
            ->get();

        $process = PayrollProcess::updateOrCreate([
            'type_id' => $typeId,
            'month' => $month,
            'year' => $year,
        ],
            [
                'approved_status' => 'p'
            ],
        );

        //CREATE VARIABLE TOTAL EMPLOYEE AND TOTAL VALUE
        $totalEmployees = 0;
        $totalValues = 0;

        //CREATE ARRAY COMPONENT
        $components = PayrollComponent::where('type_id', $typeId)->pluck('id', 'code')->toArray();

        //DELETE EXISTING DETAIL PROCESS
        PayrollProcessDetail::where('process_id', $process->id)->delete();

        //SET UPLOAD COMPONENT LIST
        $uploadComponents = PayrollComponent::active()->where('type_id', $typeId)
            ->where('method', 2)
            ->where('method_value', 'payroll_uploads')
            ->pluck('code', 'id')
            ->toArray();
        $uploads = DB::table('payroll_uploads as t1')
            ->join('payroll_upload_details as t2', 't1.id', 't2.upload_id')
            ->select('t1.code', 't2.employee_id', 't2.value')
            ->where('t1.month', $month)
            ->where('t1.year', $year)->get();
        foreach ($uploads as $r) {
            $uploadValues[$r->code][$r->employee_id] = $r->value;
        }

        //SET TABLE COMPONENT LIST
        $tableComponents = PayrollComponent::active()->where('type_id', $typeId)
            ->where('method', 2)
            ->where('method_value', '!=', 'payroll_uploads')
            ->get();
        foreach ($tableComponents as $r) {
            $methodValue = explode(', ', $r->method_value);
            $table = DB::table($methodValue[0])->get();
            if ($methodValue[1] == 'rank') {
                foreach ($table as $value) {
                    $tableValues[$r->code][$value->rank_id] = $value->value;
                }
            }
        }

        //SET FIXED COMPONENT LIST
        $fixedComponents = PayrollComponent::active()->where('type_id', $typeId)
            ->where('method', 3)
            ->get();

        foreach ($employees as $emp) {
            //SET TABLE DATA
            if (isset($tableValues)) {
                foreach ($tableValues as $key => $value) {
                    $componentValue = isset($tableValues[$key][$emp->rank_id]) ? $tableValues[$key][$emp->rank_id] : 0;
                    PayrollProcessDetail::create([
                        'process_id' => $process->id,
                        'employee_id' => $emp->id,
                        'component_id' => $components[$key],
                        'value' => $componentValue
                    ]);
                    $totalValues += $componentValue;
                }
            }

            //SET UPLOADED DATA
            if (isset($uploadComponents)) {
                foreach ($uploadComponents as $key => $value) {
                    $componentValue = isset($uploadValues[$value][$emp->id]) ? $uploadValues[$value][$emp->id] : 0;
                    PayrollProcessDetail::create([
                        'process_id' => $process->id,
                        'employee_id' => $emp->id,
                        'component_id' => $components[$value],
                        'value' => $componentValue
                    ]);

                    $totalValues += $componentValue;
                }
            }

            //SET FIXED DATA
            if (isset($fixedComponents)) {
                foreach ($fixedComponents as $key => $value) {
                    PayrollProcessDetail::create([
                        'process_id' => $process->id,
                        'employee_id' => $emp->id,
                        'component_id' => $components[$value->code],
                        'value' => $value->method_value
                    ]);

                    $totalValues += $value->method_value;

                }
            }

            //INCREMENT TOTAL EMPLOYEE AND TOTAL VALUE
            $totalEmployees++;
        }

        //SET TOTAL VALUE AND EMPLOYEE TO RELATED PROCESS
        $process->total_employees = $totalEmployees;
        $process->total_values = $totalValues;
        $process->save();

        Alert::success('Success', 'Proses gaji berhasil dilakukan!');

        return redirect()->route('payrolls.process.show', [$typeId, $month, $year]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approveEdit($id)
    {
        $data['process'] = PayrollProcess::find($id);
        $data['status'] = defaultStatusApproval();

        return view('payrolls.process.approve-form', $data);
    }

    public function approveUpdate(Request $request, $id)
    {
        $upload = PayrollProcess::find($id);
        $upload->approved_by = \Auth::user()->id;
        $upload->approved_date = resetDate($request->approved_date);
        $upload->approved_description = $request->approved_description;
        $upload->approved_status = $request->approved_status;
        $upload->save();

        Alert::success('Success', 'Data penggajian berhasil di Simpan');

        return redirect()->route('payrolls.process.index');
    }

    public function detail($processId, $employeeId)
    {
        $data['emp'] = Employee::with('contract')->find($employeeId);
        $data['position'] = Master::find($data['emp']->contract->position_id)->name;

        $data['allowances'] = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t2.status', 't')
            ->where('t2.type', 't')
            ->where('t1.process_id', $processId)
            ->where('t1.employee_id', $employeeId)
            ->orderBy('t2.id')
            ->get();

        $data['deductions'] = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t2.status', 't')
            ->where('t2.type', 'f')
            ->where('t1.process_id', $processId)
            ->where('t1.employee_id', $employeeId)
            ->orderBy('t2.id')
            ->get();

        $data['process'] = PayrollProcess::find($processId);
        $data['processId'] = $processId;
        $data['id'] = $employeeId;

        return view('payrolls.process.pay-detail', $data);
    }

    public function printPdf($processId, $id)
    {
        $data['emp'] = Employee::with('contract', 'payroll')->find($id);
        $data['position'] = Master::find($data['emp']->contract->position_id)->name;
        $data['location'] = Master::find($data['emp']->contract->location_id)->name;
        $data['bank'] = !empty($data['emp']->payroll->bank_id) ? Master::find($data['emp']->payroll->bank_id)->name." - ".$data['emp']->payroll->account_number : '';
        $data['process'] = PayrollProcess::find($processId);
        $data['allowances'] = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t2.type', 't')
            ->where('t1.process_id', $processId)
            ->where('t1.employee_id', $id)
            ->orderBy('t2.id')
            ->get();

        $data['deductions'] = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t2.type', 'f')
            ->where('t1.process_id', $processId)
            ->where('t1.employee_id', $id)
            ->orderBy('t2.id')
            ->get();
        $pdf = PDF::loadView('payrolls.process.pay-slip', $data);
        $pdf->addInfo(['Title' => $data['emp']->name."_".$data['emp']->emp_number."_".numToMonth($data['process']->month)."_".$data['process']->year.'.pdf']);
//            ->save(storage_path('app/public/uploads/payroll/payslip/'.$data['emp']->name."_".$data['emp']->emp_number."_".numToMonth($data['process']->month)."_".$data['process']->year.'.pdf'));

        return $pdf->stream();
    }
}
