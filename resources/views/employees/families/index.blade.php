@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('employees.families.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Keluarga</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Name</th>
                    <th width="10%">NIK</th>
                    <th width="15%">Posisi</th>
                    <th width="15%">Keluarga</th>
                    <th width="15%">Hubungan</th>
                    <th width="3%">File</th>
                    <th width="13%" style="text-align: center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$families->isEmpty())
                    @foreach($families as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->emp_number }}</td>
                            <td>{{ $masters['EJP'][$r->position_id] }}</td>
                            <td>{{ $r->familyName }}</td>
                            <td>{{ $masters['EHK'][$r->relation_id] }}</td>
                            <td align="center">
                                @if($r->filename)
                                    <a href="{{ asset('storage'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('employees.families.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('employees.families.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($families) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
