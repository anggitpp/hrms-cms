@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('employees.'.$arrMenu['target'].'.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Pegawai </a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Nama</th>
                    <th width="15%">NIK</th>
                    <th width="15%">Posisi</th>
                    <th width="10%">Pangkat</th>
                    <th width="13%">Tanggal Masuk</th>
                    <th width="10%">Status</th>
                    <th width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$employees->isEmpty())
                    @foreach($employees as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->emp_number }}</td>
                            <td>{{ $masters['EJP'][$r->position_id] }}</td>
                            <td>{{ $masters['EP'][$r->rank_id] }}</td>
                            <td>{{ setDate($r->join_date) }}</td>
                            <td>{{ $masters['ESP'][$r->status_id] }}</td>
                            <td align="center">
                                <a href="{{ route('employees.'.$arrMenu['target'].'.show', $r->id) }}" class="btn btn-icon btn-info"><i data-feather="list"></i></a>
                                @if(isset($access['edit']))
                                    <a href="{{ route('employees.'.$arrMenu['target'].'.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('employees.'.$arrMenu['target'].'.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            {{ generatePagination($employees) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
