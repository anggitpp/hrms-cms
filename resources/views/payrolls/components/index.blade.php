@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select name="filterType" :datas="$types" value="{{ $filterType }}" event="document.getElementById('form').submit();" />
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('payrolls.'.$arrMenu['target'].'.create', $filterType ?? '') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Komponen</a>
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
                @if(!$components->isEmpty())
                    @foreach($components as $key => $r)
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
                                    <a class="btn btn-icon btn-primary" href="{{ route('payrolls.'.$arrMenu['target'].'.edit', $r->id) }}">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('payrolls.'.$arrMenu['target'].'.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($components) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
