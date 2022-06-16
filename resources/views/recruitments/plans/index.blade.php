@extends('app')
@section('content')
    @php
    $url = '/recruitments/plans/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('recruitments.plans.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Kebutuhan</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%">Nomor</th>
                    <th width="20%">Judul</th>
                    <th width="15%">Tgl Pengajuan</th>
                    <th width="15%">Posisi</th>
                    <th width="10%">Jumlah</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$plans->isEmpty())
                    @foreach($plans as $key => $r)
                        @php
                        $totalAppl = DB::table('recruitment_applicants')->where('plan_id', $r->id)->count();
                        $totalPeople = ($totalAppl ?? 0) . ' / '. ($r->number_of_people ?? 0);
                        $badge = $totalAppl >= $r->number_of_people ? 'success' : ($totalAppl != 0 ? 'info' : 'secondary');
                        @endphp
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td align="left">{{ $r->plan_number }}</td>
                            <td>{{ $r->title }}</td>
                            <td>{{ setDate($r->propose_date) }}</td>
                            <td>{{ $r->name }}</td>
                            <td><a href="#" class="badge badge-{!! $badge !!} btn-modal-form" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="show">{{ $totalPeople }}</a></td>
                            <td>{!! getStatusApproval($r->status) !!}</td>
                            <td align="center">
                                 @if(isset($access['edit']))
                                    <a href="{{ route('recruitments.plans.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('recruitments.plans.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            {{ generatePagination($plans) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-modal-form title="List Applicant" size="modal-lg"/>
@endsection
