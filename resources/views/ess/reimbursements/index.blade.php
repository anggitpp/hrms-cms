@extends('app')
@section('content')
    @include('templates.employee_header')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select-year name="filterYear" value="{{ $filterYear }}"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('ess.reimbursements.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Pengajuan</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%">Nomor</th>
                    <th class="text-center" width="10%">Tanggal</th>
                    <th width="*">Kategori</th>
                    <th width="10%">Nilai</th>
                    <th width="20%">Keterangan</th>
                    <th width="5%">Status</th>
                    <th width="13%" class="text-center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$reimbursements->isEmpty())
                    @foreach($reimbursements as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->number }}</td>
                            <td class="text-center">{{ setDate($r->date) }}</td>
                            <td>{{ $r->categoryName }}</td>
                            <td class="text-right">{{ setCurrency($r->value) }}</td>
                            <td>{{ $r->description }}</td>
                            <td>
                                @if($r->approved_status == 't')
                                    <div class="badge badge-success">Disetujui</div>
                                @elseif($r->approved_status == 'f')
                                    <div class="badge badge-danger">Ditolak</div>
                                @else
                                    <div class="badge badge-secondary">Pending</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']) && $r->approved_status != 't')
                                    <a href="{{ route('ess.reimbursements.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']) && $r->approved_status != 't')
                                    <button href="{{ route('ess.reimbursements.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($reimbursements) }}
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
