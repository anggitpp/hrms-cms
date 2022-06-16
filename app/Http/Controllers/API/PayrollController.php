<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Payroll\PayrollProcess;
use App\Models\Setting\Master;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function detail($month, $year)
    {
        $employeeId = Auth::user()->employee_id;
        $processId = DB::table('payroll_processes as t1')
            ->select('t1.id')
            ->join('payroll_process_details as t2', 't1.id', 't2.process_id')
            ->where('t1.month', $month)
            ->where('t1.year', $year)
            ->where('t1.approved_status', 't')
            ->where('t2.employee_id', $employeeId)
            ->first()
            ->id;

        $data['components'] = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name', 't2.type')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t1.process_id', $processId)
            ->where('t1.employee_id', $employeeId)
            ->orderBy('t2.id')
            ->get();

        $data['totalAllowance'] = 0;
        $data['totalDeduction'] = 0;

        foreach ($data['components'] as $key => $value){
            if($value->type == "t"){
                $data['totalAllowance'] += $value->value;
            }else{
                $data['totalDeduction'] += $value->value;
            }
        }

        $data['takeHomePay'] = $data['totalAllowance'] - $data['totalDeduction'];

        if($data) {
            return response()->json([
                "data" => $data,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }

    public function printPdf($month, $year)
    {
        $employeeId = Auth::user()->employee_id;
        $emp = Employee::find($employeeId);
        $pdfName = $emp->name."_".$emp->emp_number."_".numToMonth($month)."_".$year.'.pdf';

        $pdf = $this->pdf($employeeId, $month, $year);

        if($pdf) {
            return response()->json([
                "data" => $pdfName,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }

    }

    public function pdf($employeeId, $month, $year){
        $emp = Employee::with('contract', 'payroll')->find($employeeId);
        $position = Master::find($emp->contract->position_id)->name;
        $location = Master::find($emp->contract->location_id)->name;
        $bank = !empty($emp->payroll->bank_id) ? Master::find($emp->payroll->bank_id)->name." - ".$emp->payroll->account_number : '';
        $process = PayrollProcess::where('month', $month)->where('year', $year)->where('type_id', $emp->payroll->payroll_id)
            ->where('approved_status', 't')
            ->first();

        $allowances = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t2.type', 't')
            ->where('t1.process_id', $process->id)
            ->where('t1.employee_id', $employeeId)
            ->orderBy('t2.id')
            ->get();

        $deductions = DB::table('payroll_process_details as t1')
            ->select('t1.value', 't2.name')
            ->join('payroll_components as t2', 't1.component_id', 't2.id')
            ->where('t2.type', 'f')
            ->where('t1.process_id', $process->id)
            ->where('t1.employee_id', $employeeId)
            ->orderBy('t2.id')
            ->get();

        $totalAllowances = 0;
        $totalDeductions = 0;

        $html = "
        <center>
            <img src=\"".asset('/app-assets/images/icons/logo-labora.png') ."\" height=\"80\">
        </center>
        <br/>
        <div style=\"width: 100%; position: relative; height: 100px;\">
            <div style=\"width: 48%; float: left\">
                <p style=\"font-family: sans-serif; font-size: 13; font-weight: bold; color: #9A0101; text-align: right\">
                    ".$emp->name."
                </p>
                <p style=\"font-family: sans-serif; font-size: 11; text-align: right\">
                    ".$position ."
                </p>
                <p style=\"font-family: sans-serif; font-size: 11; text-align: right\">
                    ".$emp->emp_number ."
                </p>
            </div>
            <div style=\"width: 4%; float: left\">
                &nbsp;
            </div>
            <div style=\"width: 48%;float: left\">
                <p style=\"font-size: 13; font-weight: bold; text-align: left\">
                    ".numToMonth($process->month)." ".$process->year ."
                </p>
                <p style=\"font-size: 11; text-align: left\">
                    ".$location ."
                </p>
                <p style=\"font-size: 11; text-align: left\">
                    ".$bank."
                </p>
            </div>
        </div>
        <div style=\"position: relative; height: auto\">
            <table style=\"width: 100%;\">
                <tr>
                    <td style=\"width: 48%; background-color: #E1E1E1; text-align: center\">
                        <p style=\"color: #9A0101; font-weight: bold; font-size: 12\">P E N E R I M A A N</p>
                    </td>
                    <td style=\"width: 4%\">&nbsp;</td>
                    <td style=\"width: 48%; background-color: #E1E1E1; text-align: center\">
                        <p style=\"color: #9A0101; font-weight: bold; font-size: 12\">P O T O N G A N</p>
                    </td>
                </tr>
            </table>
            <table style=\"width: 100%; font-size: 11; float: left\">
                <tr>
                    <td style=\"width: 48%;background-color: #E1E1E1;vertical-align: top\">
                        <table style=\"width: 100%; \">";
                            if($allowances->isNotEmpty()) {
                                foreach ($allowances as $key => $r) {
                                    $html .= "
                                    <tr>
                                        <td style=\"width: 50%\">" . $r->name . "</td>
                                        <td style=\"width: 10%\"></td>
                                        <td style=\"width: 40%; text-align: right\">" . setCurrency($r->value) . "</td>
                                    </tr>";
                                    $totalAllowances += $r->value;
                                }
                            }
                        $html.="
                        </table>
                    </td>
                    <td style=\"width: 4%\"></td>
                    <td style=\"width: 48%;background-color: #E1E1E1;vertical-align: top\">
                        <table style=\"width: 100%; \">";
                            if($deductions->isNotEmpty()) {
                                foreach ($deductions as $key => $r) {
                                    $html .= "
                                                    <tr>
                                                        <td style=\"width: 50%\">" . $r->name . "</td>
                                                        <td style=\"width: 10%\"></td>
                                                        <td style=\"width: 40%; text-align: right\">" . setCurrency($r->value) . "</td>
                                                    </tr>";
                                    $totalAllowances += $r->value;
                                }
                            }
                            $html.="
                        </table>
                    </td>
                </tr>
                <tfoot>
                    <tr>
                        <td style=\"width: 48%;background-color: #C0C0C0;\">
                            <table style=\"width: 100%; padding-top: 10px;\">
                                <tr>
                                    <td style=\"width: 60%\"><b>TOTAL PENERIMAAN</b></td>
                                    <td style=\"width: 5%\"></td>
                                    <td style=\"width: 45%; text-align: right\">".setCurrency($totalAllowances) ."</td>
                                </tr>
                            </table>
                        </td>
                        <td style=\"width: 4%\"></td>
                        <td style=\"width: 48%;background-color: #C0C0C0;\">
                            <table style=\"width: 100%; padding-top: 10px;\">
                                <tr>
                                    <td style=\"width: 60%\"><b>TOTAL POTONGAN</b></td>
                                    <td style=\"width: 5%\"></td>
                                    <td style=\"width: 45%; text-align: right\">". setCurrency($totalDeductions) ."</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style=\"margin-bottom:5px;\">
            &nbsp;
            <table style=\"width: 100%; background-color: #420008; padding: 5\">
                <td style=\"width: 50%; color: white\">TAKE HOME PAY</td>
                <td style=\"width: 50%; color: white; text-align: right; font-size: 13\"><b>IDR ".setCurrency($totalAllowances - $totalDeductions) ."</b></td>
            </table>
        </div>
        <style>
                p { margin:5 }
            body {
                    font-family: sans-serif;
            }
            table {
                    border-collapse: collapse;
                border-spacing: 0;
            }
            td {
                    padding: 0 5 5 5px;
            }        
        </style>
        ";

        $pdf = PDF::loadHTML($html);
        $pdf->addInfo(['Title' => $emp->name."_".$emp->emp_number."_".numToMonth($process->month)."_".$process->year.'.pdf'])
            ->save(storage_path('app/public/uploads/payroll/payslip/'.$emp->name."_".$emp->emp_number."_".
                numToMonth($process->month)."_".$process->year.'.pdf'));

        return $pdf;
    }
}
