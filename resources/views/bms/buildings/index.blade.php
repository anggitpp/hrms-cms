@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                @if(!Session::get('sessionBuilding'))
                    <x-form.select name="filterRegion" class="mr-1" options="- Pilih Wilayah -" :datas="$regions" value="{{ $filterRegion ?? '' }}"/>
                @endif
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('bms.buildings.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Gedung</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Nama</th>
                    <th width="5%">Code</th>
                    <th width="15%">Wilayah</th>
                    <th width="10%">Tipe</th>
                    <th width="5%">Status</th>
                    <th width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$buildings->isEmpty())
                    @foreach($buildings as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $masters['ELK'][$r->region_id] }}</td>
                            <td>{{ $masters['BTP'][$r->type_id] }}</td>
                            <td align="center">
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('bms.buildings.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('bms.buildings.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($buildings) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
