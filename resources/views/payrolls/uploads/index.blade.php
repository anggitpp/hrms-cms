@php
    $arrKode = array("overtime" => "OVT", "meal" => "MEAL");
    $url = "/payrolls/".$arrMenu['target']."/";
@endphp
    @extends('app')
    @section('content')
        <div class="card">
            <div class="card-header justify-content-between">
                <form class="form-inline" method="GET" id="form">
                    <x-form.select-year name="filterYear" class="mr-1" value="{{ $filterYear }}" placeholder="Search .."/>
                    <input type="submit" class="btn btn-primary" value="GO">
                </form>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="10%">Bulan</th>
                        <th width="15%" class="text-center">Total Pegawai</th>
                        <th width="*" class="text-center">Total Nilai</th>
                        <th width="12%">Status Approve</th>
                        <th width="12%">Diapprove Oleh</th>
                        <th width="5%">Upload</th>
                    </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i<=12; $i++)
                            @php
                                $r = DB::table('payroll_uploads')->where('month', $i)->where('year', $filterYear)->where('code', $arrKode[$arrMenu['parameter']])->first();
                                $totalValues = !empty($r->total_values) ? setCurrency($r->total_values) : '';
                                $approvedBy = !empty($r->approved_by) ? DB::table('app_users')->find($r->approved_by)->name : '';
                            @endphp
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ numToMonth($i) }}</td>
                            <td class="text-center">{{ $r->total_employees ?? '' }}</td>
                            <td class="text-center">{{ $totalValues }}</td>
                            <td>
                                @if(!empty($r->approved_status))
                                    <a href="#" class="btn-modal" data-url="{{ $url }}" data-action="approve/edit" data-id="{{ $r->id }}">
                                        @if($r->approved_status == 't')
                                            <div class="badge badge-success">Disetujui</div>
                                        @elseif($r->approved_status == 'f')
                                            <div class="badge badge-danger">Ditolak</div>
                                        @else
                                            <div class="badge badge-secondary">Pending</div>
                                        @endif
                                    </a>
                                @endif
                            </td>
                            <td>{{ $approvedBy }}</td>
                            <td class="text-center">
                                <a href="{{ route('payrolls.'.$arrMenu['target'].'.show', [$i, $filterYear]) }}" class="btn btn-icon btn-info">
                                    <i data-feather="list"></i>
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
    <x-side-modal-form title="Approve {{ $arrMenu['name'] }} "/>
@endsection
