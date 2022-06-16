@extends('app')
@section('content')
    @php
        $url = '/employees/terminations/approve/';

    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('employees.terminations.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Termination</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="8%">Nomor</th>
                    <th width="5%">Tanggal</th>
                    <th width="*">Nama</th>
                    <th width="12%">NIK</th>
                    <th width="12%">Kategori</th>
                    <th width="8%">Efektif</th>
                    <th style="text-align: center" width="5%">Approve</th>
                    <th width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$terminations->isEmpty())
                    @foreach($terminations as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->termination_number }}</td>
                            <td>{{ setDate($r->effective_date) }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->emp_number }}</td>
                            <td>{{ $masters['ESP'][$r->category_id] }}</td>
                            <td>{{ setDate($r->effective_date) }}</td>
                            <td align="left">
                                <a href="#" class="btn btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                    @if($r->approve_status == 't')
                                        <div class="badge badge-success">Disetujui</div>
                                    @elseif($r->approve_status == 'f')
                                        <div class="badge badge-danger">Ditolak</div>
                                    @else
                                        <div class="badge badge-warning">Process</div>
                                    @endif
                                </a>
                            </td>
                            <td align="center">
                                @if($r->approve_status != 't')
                                    @if(isset($access['edit']))
                                        <a href="{{ route('employees.terminations.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                    @endif
                                    @if(isset($access['destroy']))
                                        <button href="{{ route('employees.terminations.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    @endif
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
            {{ generatePagination($terminations) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Modul"/>
@endsection
