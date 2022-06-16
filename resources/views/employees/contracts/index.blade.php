@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('employees.contracts.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Kontrak</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Nama</th>
                    <th width="10%">NIK Pegawai</th>
                    <th width="15%">Posisi</th>
                    <th width="10%">Pangkat</th>
                    <th width="10%">Tgl Mulai</th>
                    <th width="11%">Tgl Selesai</th>
                    <th width="5%">File</th>
                    <th width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$contracts->isEmpty())
                    @foreach($contracts as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->emp_number }}</td>
                            <td>{{ $masters['EJP'][$r->position_id] }}</td>
                            <td>{{ $masters['EP'][$r->rank_id] }}</td>
                            <td>{{ setDate($r->start_date) }}</td>
                            <td>{{ $r->end_date ? setDate($r->end_date) : '' }}</td>
                            <td align="center">
                                @if($r->filename)
                                    <a href="{{ asset('storage'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('employees.contracts.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('employees.contracts.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($contracts) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
