@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Object</th>
                    <th width="15%">Sasaran</th>
                    <th width="15%">Aktifitas</th>
                    <th style="text-align: center" width="8%">Detail</th>
                </tr>
                </thead>
                <tbody>
                @if(!$masters->isEmpty())
                    @foreach($masters as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td align="center">{{ $totalTarget[$r->id] ?? 0 }}</td>
                            <td align="center">{{ $totalActivities[$r->id] ?? 0  }}</td>
                            <td align="center">
                                <a href="{{ route('bms.'.$arrMenu['target'].'.show', $r->id) }}" class="btn btn-icon btn-info"><i data-feather="list"></i></a>
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
            {{ generatePagination($masters) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
