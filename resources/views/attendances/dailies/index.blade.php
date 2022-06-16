@extends('app')
@section('content')
    @php
        $url = '/attendances/dailies/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter ?? '' }}" placeholder="Search .."/>
                <x-form.datepicker class="col-md-10 mr-1" name="filterDate" value="{{ $filterDate }}" />
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <div>
                @if(isset($access['export']))
                    <a href="{{ route('attendances.dailies.export', ['filter' => $filter, 'filterDate' => $filterDate]) }}" class="btn btn-success"><i data-feather='file'></i> Export Data</a>
                @endif
                @if(isset($access['import']))
                    <button class="btn btn-info btn-modal-form" data-toggle="modal" data-form="menu" data-action="import" data-url="{{ $url }}">
                        <i data-feather='inbox'></i> Import Data
                    </button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th style="min-width: 50px;" class="text-center">No</th>
                    <th style="min-width: 200px;">Nama</th>
                    <th style="min-width: 100px;">NIK</th>
                    <th style="min-width: 100px;">Tanggal</th>
                    <th style="text-align: center; min-width: 145px;">Jadwal Masuk</th>
                    <th style="text-align: center; min-width: 145px;">Jadwal Keluar</th>
                    <th style="text-align: center; min-width: 80px;">Masuk</th>
                    <th style="text-align: center;min-width: 80px;">Pulang</th>
                    <th style="text-align: center;min-width: 80px;">Durasi</th>
                    <th style="min-width: 180px;">Keterangan</th>
                </tr>
                </thead>
                <tbody>
                @if(!$attendances->isEmpty())
                    @foreach($attendances as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td align="center">{{ $r->emp_number }}</td>
                            <td>{{ setDate($r->date) }}</td>
                            <td align="center">{{ substr($r->start, 0, 5) }}</td>
                            <td align="center">{{ substr($r->end, 0, 5) }}</td>
                            <td align="center">{{ substr($r->in, 0, 5) }}</td>
                            <td align="center">{{ substr($r->out, 0, 5) }}</td>
                            <td align="center">{{ substr($r->duration, 0, 5) }}</td>
                            <td>{{ $r->description }}</td>
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
            {{ generatePagination($attendances) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-modal-form title="Import Data Absen"/>
@endsection
