@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <a href="{{ route('ess.leave_masters.create') }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Master Cuti</a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Nama</th>
                    <th width="10%">Jumlah</th>
                    <th class="text-center" width="20%">Masa Berlaku</th>
                    <th width="15%">Berlaku Untuk</th>
                    <th width="13%" class="text-center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$masters->isEmpty())
                    @foreach($masters as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td class="text-right">{{ $r->quota }}</td>
                            <td class="text-center">{{ setDate($r->start_date)." s/d ".setDate($r->end_date) }}</td>
                            <td>{{ $r->location_id ? $locations[$r->location_id] : 'Semua Lokasi' }}</td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('ess.leave_masters.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('ess.leave_masters.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($masters) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
