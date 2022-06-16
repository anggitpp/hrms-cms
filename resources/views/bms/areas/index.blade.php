@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                @if(!Session::get('sessionBuilding'))
                    <x-form.select name="filterRegion" class="mr-1" options="- Semua Wilayah -" :datas="$regions" value="{{ $filterRegion }}" event="document.getElementById('form').submit();"/>
                @endif
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Nama</th>
                    <th width="15%">Wilayah</th>
                    <th width="10%">Tipe</th>
                    <th width="5%">Area</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="8%">Detail</th>
                </tr>
                </thead>
                <tbody>
                @if(!$buildings->isEmpty())
                    @foreach($buildings as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $masters['ELK'][$r->region_id] }}</td>
                            <td>{{ $masters['BTP'][$r->type_id] }}</td>
                            <td>{{ $totalArea[$r->id] ?? 0 }}</td>
                            <td align="center">
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{ route('bms.'.$arrMenu['target'].'.areas', $r->id) }}" class="btn btn-icon btn-info"><i data-feather="list"></i></a>
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
            min-width: 200px;
        }
    </style>
@endsection
