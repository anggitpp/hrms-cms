<center>
{{--    <img src="{{ public_path('/app-assets/images/icons/logo-labora.png') }}" height="80">--}}
    <img src="{{ asset('/app-assets/images/icons/logo-labora.png') }}" height="80">
</center>
<br/>
<div style="width: 100%; position: relative; height: 100px;">
    <div style="width: 48%; float: left">
        <p style="font-family: sans-serif; font-size: 13; font-weight: bold; color: #9A0101; text-align: right">
            {{ $emp->name }}
        </p>
        <p style="font-family: sans-serif; font-size: 11; text-align: right">
            {{ $position }}
        </p>
        <p style="font-family: sans-serif; font-size: 11; text-align: right">
            {{ $emp->emp_number }}
        </p>
    </div>
    <div style="width: 4%; float: left">
        &nbsp;
    </div>
    <div style="width: 48%;float: left">
        <p style="font-size: 13; font-weight: bold; text-align: left">
            {{ numToMonth($process->month)." ".$process->year }}
        </p>
        <p style="font-size: 11; text-align: left">
            {{ $location }}
        </p>
        <p style="font-size: 11; text-align: left">
            {{ $bank }}
        </p>
    </div>
</div>
<div style="position: relative; height: auto">
    <table style="width: 100%;">
        <tr>
            <td style="width: 48%; background-color: #E1E1E1; text-align: center">
                <p style="color: #9A0101; font-weight: bold; font-size: 12">P E N E R I M A A N</p>
            </td>
            <td style="width: 4%">&nbsp;</td>
            <td style="width: 48%; background-color: #E1E1E1; text-align: center">
                <p style="color: #9A0101; font-weight: bold; font-size: 12">P O T O N G A N</p>
            </td>
        </tr>
    </table>
    @php
    $totalAllowances = 0;
    $totalDeductions = 0;
    @endphp
    <table style="width: 100%; font-size: 11; float: left">
        <tr>
            <td style="width: 48%;background-color: #E1E1E1;vertical-align: top">
                <table style="width: 100%; ">
                    @if($allowances->isNotEmpty())
                        @foreach($allowances as $key => $r)
                            <tr>
                                <td style="width: 50%">{{ $r->name }}</td>
                                <td style="width: 10%"></td>
                                <td style="width: 40%; text-align: right">{{ setCurrency($r->value) }}</td>
                            </tr>
                            @php
                                $totalAllowances += $r->value;
                            @endphp
                        @endforeach
                    @endif
                </table>
            </td>
            <td style="width: 4%"></td>
            <td style="width: 48%;background-color: #E1E1E1;vertical-align: top">
                <table style="width: 100%; ">
                    @if($deductions->isNotEmpty())
                        @foreach($deductions as $key => $r)
                            <tr>
                                <td style="width: 50%">{{ $r->name }}</td>
                                <td style="width: 10%"></td>
                                <td style="width: 40%; text-align: right">{{ setCurrency($r->value) }}</td>
                            </tr>
                            @php
                                $totalDeductions += $r->value;
                            @endphp
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
        <tfoot>
        <tr>
            <td style="width: 48%;background-color: #C0C0C0;">
                <table style="width: 100%; padding-top: 10px;">
                    <tr>
                        <td style="width: 60%"><b>TOTAL PENERIMAAN</b></td>
                        <td style="width: 5%"></td>
                        <td style="width: 45%; text-align: right">{{ setCurrency($totalAllowances) }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 4%"></td>
            <td style="width: 48%;background-color: #C0C0C0;">
                <table style="width: 100%; padding-top: 10px;">
                    <tr>
                        <td style="width: 60%"><b>TOTAL POTONGAN</b></td>
                        <td style="width: 5%"></td>
                        <td style="width: 45%; text-align: right">{{ setCurrency($totalDeductions) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        </tfoot>
    </table>
</div>
<div style="margin-bottom:5px;">
    &nbsp;
    <table style="width: 100%; background-color: #420008; padding: 5">
        <td style="width: 50%; color: white">TAKE HOME PAY</td>
        <td style="width: 50%; color: white; text-align: right; font-size: 13"><b>IDR {{ setCurrency($totalAllowances - $totalDeductions) }}</b></td>
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