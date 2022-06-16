@extends('app')
@section('content')
    @php
        $url = '/attendances/shifts/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="create" data-url="{{ $url }}">
                    <i data-feather='plus'></i> Tambah Shift
                </button>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th style="text-align: center" width="10%">Kode</th>
                    <th width="*">Nama</th>
                    <th style="text-align: center" width="10%">Mulai</th>
                    <th style="text-align: center" width="10%">Selesai</th>
                    <th width="20%">Keterangan</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$shifts->isEmpty())
                    @foreach($shifts as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td align="center">{{ $r->code }}</td>
                            <td>{{ $r->name }}</td>
                            <td align="center">{{ substr($r->start,0,5) }}</td>
                            <td align="center">{{ substr($r->end,0,5) }}</td>
                            <td>{{ $r->description }}</td>
                            <td align="left">
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('attendances.shifts.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($shifts) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Shift"/>
@endsection
