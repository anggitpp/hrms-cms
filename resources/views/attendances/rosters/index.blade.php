@extends('app')
@section('content')
    @php
        $url = '/attendances/shifts/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter ?? '' }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Nama</th>
                    <th style="text-align: center" width="12%">NIK</th>
                    <th style="text-align: center" width="10%">Posisi</th>
                    <th style="text-align: center" width="10%">Kode</th>
                    <th width="12%">Shift</th>
                    <th style="text-align: center" width="5%">Mulai</th>
                    <th style="text-align: center" width="5%">Selesai</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$rosters->isEmpty())
                    @foreach($rosters as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td align="center">{{ $r->emp_number }}</td>
                            <td>{{ $r->posName }}</td>
                            <td>{{ '' }}</td>
                            <td>{{ $r->shiftName }}</td>
                            <td align="center">{{ substr($r->start,0,5) }}</td>
                            <td align="center">{{ substr($r->end,0,5) }}</td>
                            <td align="center">
                                <a href="{{ route('attendances.rosters.edit', $r->id) }}" class="btn btn-icon btn-info">
                                    <i data-feather="list"></i>
                                </a>
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
            {{ generatePagination($rosters) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Shift"/>
@endsection
