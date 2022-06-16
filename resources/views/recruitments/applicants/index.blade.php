@extends('app')
@section('content')
    @php
    $arrSelection = array("verification" => 'Verifikasi', "psychological" => 'Psikotest', "hr" => 'Interview HR',
    "user" => 'User', "mcu" => 'MCU', "final" => 'Final');
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('recruitments.applicants.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Pelamar</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="18%">Nama</th>
                    <th width="10%">Tanggal</th>
                    <th width="25%">Rencana Kebutuhan</th>
                    <th width="15%">Posisi</th>
                    <th width="10%">Status</th>
                    <th width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$applicants->isEmpty())
                    @foreach($applicants as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>
                                {{ $r->name }}<br>
                                <i><b>{{ $r->applicant_number }}</b></i>
                            </td>
                            <td>{{ setDate($r->input_date) }}</td>
                            <td>{{ $r->title }}</td>
                            <td>{{ $r->position }}</td>
                            <td>
                                @if($r->selection_result)
                                    @if($r->selection_result == 't')
                                        <div class="badge badge-success">{{ $arrSelection[$r->selection_step] }}</div>
                                    @else
                                            <div class="badge badge-danger">{{ $arrSelection[$r->selection_step] == 'Lulus'  ? 'Tidak Lulus'  : $arrSelection[$r->selection_step] }}</div>
                                    @endif
                                @else
                                    <div class="badge badge-danger">Verifikasi</div>
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{ route('recruitments.applicants.show', $r->id) }}" class="btn btn-icon btn-info"><i data-feather="list"></i></a>
                                @if(isset($access['edit']))
                                    <a href="{{ route('recruitments.applicants.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('recruitments.applicants.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($applicants) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
