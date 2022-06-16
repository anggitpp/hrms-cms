@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                <x-form.select name="filterRegion" class="mr-1" :datas="$regions" value="{{ $filterRegion }}"  all="- Semua Wilayah -" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Nama</th>
                    <th width="10%">NIK</th>
                    <th width="15%">Jabatan</th>
                    <th width="10%">No. HP</th>
                    <th style="text-align: center" width="13%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$employees->isEmpty())
                    @foreach($employees as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->emp_number }}</td>
                            <td>{{ $masters['EP'][$r->contract->rank_id]  }}</td>
                            <td>{{ $r->mobile_phone }}</td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('bms.mappings.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
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
    <style>
        .select2{
            min-width: 200px;
        }
    </style>
@endsection
