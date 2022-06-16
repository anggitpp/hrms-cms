@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select-year name="filterYear" value="{{ $filterYear }}"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('staff.overtimes.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Pengajuan</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%">Nomor</th>
                    <th width="*">Nama</th>
                    <th width="10%">NIK</th>
                    <th width="12%">Tanggal</th>
                    <th width="10%">Jam Mulai</th>
                    <th width="10%">Jam Selesai</th>
                    <th width="5%">Status</th>
                    <th width="13%" class="text-center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$overtimes->isEmpty())
                    @foreach($overtimes as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td class="text-center">{{ $r->number }}</td>
                            <td>{{ $r->name }}</td>
                            <td class="text-center">{{ $r->emp_number }}</td>
                            <td class="text-center">{{ setDate($r->start_date) }}</td>
                            <td>{{ $r->start_time }}</td>
                            <td>{{ $r->end_time }}</td>
                            <td>
                                @if(isset($access['approve/edit']))
                                    <a href="{{ route('staff.overtimes.approve.edit', $r->id) }}">
                                @endif
                                @if($r->approved_status == 't')
                                    <div class="badge badge-success">Disetujui</div>
                                @elseif($r->approved_status == 'f')
                                    <div class="badge badge-danger">Ditolak</div>
                                @else
                                    <div class="badge badge-secondary">Pending</div>
                                @endif
                                @if(isset($access['approve/edit']))
                                    </a>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']) && $r->approved_status != 't')
                                    <a href="{{ route('staff.overtimes.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']) && $r->approved_status != 't')
                                    <button href="{{ route('staff.overtimes.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            {{ generatePagination($overtimes) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <style>
        .select2{
            min-width: 100px;
        }
    </style>
@endsection
