@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="#" data-url="/payrolls/types/" data-action="create" class="btn btn-primary btn-modal"><i data-feather='plus'></i> Tambah Master Gaji</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%">Kode</th>
                    <th width="20%">Nama</th>
                    <th width="*">Deskripsi</th>
                    <th width="5%">Status</th>
                    <th width="13%" style="text-align: center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$types->isEmpty())
                    @foreach($types as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->description }}</td>
                            <td>
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="/payrolls/types/" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('payrolls.types.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($types) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Master Gaji"/>
@endsection
