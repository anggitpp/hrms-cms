@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                <x-form.select name="filterObject" class="mr-1" :datas="$objects" options="- Filter Objek -" value="{{ $filterObject }}" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['activity/create']))
                <a href="{{ route('bms.'.$arrMenu['target'].'.activity.create', $id) }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Aktifitas</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Aktifitas</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Model</th>
                    <th width="10%">Satuan</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="13%">Detail</th>
                </tr>
                </thead>
                <tbody>
                @if(!$targets->isEmpty())
                    @foreach($targets as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="center">
                                <a href="{{ route('bms.'.$arrMenu['target'].'.activity.create', array($id, $r->id)) }}" class="btn btn-icon btn-success"><i data-feather="plus-square"></i></a>
                            </td>
                        </tr>
                        @if(!$r->masters->isEmpty())
                            @foreach($r->masters as $k => $master)
                                <tr>
                                    <td></td>
                                    <td><span style="margin-left: 20px;">{{ strtolower(numToAlpha($k)).". ". $master->name }}</span></td>
                                    <td>{{ $masters['AKKA'][$master->category_id] ?? '' }}</td>
                                    <td>{{ $controlType[$master->control_type] ?? '' }}</td>
                                    <td>{{ $masters['AKST'][$master->control_unit_id] ?? '' }}</td>
                                    <td>
                                        <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                                    </td>
                                    <td align="center">
                                        @if(isset($access['activity/edit']))
                                            <a href="{{ route('bms.'.$arrMenu['target'].'.activity.edit', $master->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                        @endif
                                        @if(isset($access['activity/destroy']))
                                            <button href="{{ route('bms.'.$arrMenu['target'].'.activity.destroy', $master->id) }}" id="delete" class="btn btn-icon btn-danger">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
{{--            {{ generatePagination($targets) }}--}}
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
