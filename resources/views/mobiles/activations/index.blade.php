@extends('app')
@section('content')
{{--    @dd()--}}
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
                <div style="position:absolute; right: 5px;">
                    <x-form.radio name="filterStatus" class="mr-1" value="{{ $filterStatus }}" :datas="$status" event="document.getElementById('form').submit();"/>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%">Username</th>
                    <th width="*">Nama User</th>
                    <th width="15%">Perangkat</th>
                    <th width="12%">Tanggal</th>
                    <th width="10%">Jam</th>
                    <th width="5%">Status</th>
                    <th width="13%" style="text-align: center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$activations->isEmpty())
                    @foreach($activations as $key => $r)
                        @php
                          list($date, $time) = explode(' ', $r->created_at);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->username }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->device_name }}</td>
                            <td>{{ $date }}</td>
                            <td>{{ substr($time, 0, 5) }}</td>
                            <td>
                                <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="/mobiles/activations/" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
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
            {{ generatePagination($activations) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Menu"/>
@endsection
