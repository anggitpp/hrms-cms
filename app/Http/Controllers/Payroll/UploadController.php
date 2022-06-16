<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Imports\Payroll\OvertimeImport;
use App\Imports\Payroll\PayrollImport;
use App\Models\Payroll\PayrollUpload;
use App\Models\Payroll\PayrollUploadDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filterYear'] = $request->get('filterYear') ?? date('Y');
        $data['uploads'] = PayrollUpload::get();

        return !empty(access('index')) ? view('payrolls.uploads.'.$this->menu()->parameter, $data) : abort(401);
    }

    public function import($month, $year)
    {
        $data['month'] = $month;
        $data['year'] = $year;
        return view('payrolls.uploads.import', $data);
    }

    /**
     * Import data from excel
     */
    public function importData($month, $year, Request $request)
    {
        $arrKode = array("overtime" => "OVT", "meal" => "MEAL");

        $payroll = PayrollUpload::updateOrCreate(
            [
            'code' => $arrKode[$this->menu()->parameter],
            'month' => $month,
            'year' => $year,
            ],
            [
            'approved_status' => 'p',

            ]
        );

        $import = Excel::import(new PayrollImport($payroll->id), $request->file('filename'));

        if($import) {
            $getTotalEmployees = PayrollUploadDetail::where('upload_id', $payroll->id)->count('employee_id');
            $getTotalPrices = PayrollUploadDetail::where('upload_id', $payroll->id)->sum('value');

            $payroll->total_employees = $getTotalEmployees;
            $payroll->total_values = $getTotalPrices;
            $payroll->save();
        }

        return response()->json([
            'success'=> $this->menu()->name.' selesai di import',
            'url'=> route('payrolls.'.$this->menu()->target.'.show', [$month, $year])
        ]);
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
    public function show(Request $request, $month, $year)
    {
        $arrKode = array("overtime" => "OVT", "meal" => "MEAL");

        $data['month'] = $month;
        $data['year'] = $year;
        $sql = DB::table('payroll_upload_details as t1')
            ->select('t1.value', 't2.name', 't2.emp_number')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->join('payroll_uploads as t3', 't1.upload_id', 't3.id')
            ->where('t3.month', $month)
            ->where('t3.code', $arrKode[$this->menu()->parameter])
            ->where('t3.year', $year);
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter'])) {
            $sql->where(function ($sql) use ($data) {
                $sql->where('name', 'like', '%' . $data['filter'] . '%')
                    ->orWhere('emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
            });
        }
        $data['details'] = $sql->paginate($this->defaultPagination($request));
        $data['period'] = numToMonth($month)." ".$year;

        return view('payrolls.uploads.detail', $data);
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

    public function approveEdit($id)
    {
        $data['upload'] = PayrollUpload::find($id);
        $data['status'] = defaultStatusApproval();

        return view('payrolls.uploads.approve-form', $data);
    }

    public function approveUpdate(Request $request, $id)
    {
        $upload = PayrollUpload::find($id);
        $upload->approved_by = \Auth::user()->id;
        $upload->approved_date = resetDate($request->approved_date);
        $upload->approved_description = $request->approved_description;
        $upload->approved_status = $request->approved_status;
        $upload->save();

        Alert::success('Success', 'Data '.$this->menu()->name.' berhasil di Simpan');

        return redirect()->route('payrolls.'.$this->menu()->target.'.index');
    }
}
