 <div class="card">
     <div class="row">
        <div class="col-md-6">
            <div class="card-header justify-content-between">
                <h3>Penerimaan</h3>
            </div>
            <div class="table-responsive" style="{{ $process->approved_status == 't' ? 'margin-top: 5px;' : '' }}">
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
             <div class="card-header justify-content-between">
                 <h3>Potongan</h3>
                 @if($process->approved_status == 't')
                   <a href="{{ route('payrolls.process.printPdf', [$processId, $id]) }}" target="_blank" class="btn btn-success"><i data-feather='file'></i> Print Slip Gaji</a>
                 @endif
             </div>
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
                         @foreach($deductions as $key => $r)
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
</div>
