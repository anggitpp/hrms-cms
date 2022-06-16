@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.select-month name="filterMonth" value="{{ $filterMonth }}"/>
                <x-form.select-year name="filterYear" value="{{ $filterYear }}"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if($process)
                <a href="{{ route('payrolls.process.printPdf', [$processId, $id]) }}" target="_blank" class="btn btn-success"><i data-feather='file'></i> Print Slip Gaji</a>
            @endif
        </div>
        <div class="card-body">
            @if($process)
                <div class="row">
                    <div class="col-md-6">
                        <h3>Penerimaan</h3>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th width="10%">No.</th>
                                    <th width="*">Komponen</th>
                                    <th class="text-center" width="20%">Nilai</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $totalAllowances = 0;
                                @endphp
                                @if(!$allowances->isEmpty())
                                    @foreach($allowances as $key => $r)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $r->name }}</td>
                                            <td class="text-right">{{ setCurrency($r->value) }}</td>
                                        </tr>
                                        @php
                                            $totalAllowances += $r->value
                                        @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" align="center">-- Empty Data --</td>
                                    </tr>
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <b>Total</b>
                                    </td>
                                    <td class="text-right">
                                        <b>{{ setCurrency($totalAllowances) }}</b>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Potongan</h3>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th width="10%">No.</th>
                                    <th width="*">Komponen</th>
                                    <th class="text-center" width="20%">Nilai</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $totalDeductions = 0;
                                @endphp
                                @if(!$deductions->isEmpty())
                                    @foreach($deductions->contains('status', 't') as $key => $r)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $r->name }}</td>
                                            <td class="text-right">{{ setCurrency($r->value) }}</td>
                                        </tr>
                                        @php
                                            $totalDeductions += $r->value
                                        @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" align="center">-- Empty Data --</td>
                                    </tr>
                                @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <b>Total</b>
                                    </td>
                                    <td class="text-right">
                                        <b>{{ setCurrency($totalDeductions) }}</b>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h4>THP : {{ setCurrency($totalAllowances - $totalDeductions) }}</h4>
                </div>
            @else
                <div class="alert alert-primary">
                    <div class="alert-body">
                        Maaf, Payroll bulan Februari 2022 belum di proses.
                    </div>
                </div>
                <div style="height: 500px; width: 100%">&nbsp;</div>
            @endif
        </div>
    </div>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
