@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                <x-form.select name="filterLocation" class="mr-1" options="- Pilih Lokasi Kerja -" :datas="$locations" value="{{ $filterLocation ?? '' }}"/>
                <x-form.select-month name="filterMonth" class="mr-1" event="document.getElementById('form').submit();" value="{{ $filterMonth ?? date('m') }}"/>
                <x-form.select-year name="filterYear" class="mr-1" event="document.getElementById('form').submit();" value="{{ $filterYear ?? date('Y') }}"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th class="text-center" width="3%">Foto</th>
                    <th width="15%">Nama Pegawai</th>
                    <th width="5%">NIK</th>
                    <th width="5%">Tanggal</th>
                    <th width="*">Keterangan</th>
                    <th width="15%">Lokasi</th>
                    <th width="5%">Jam</th>
                    <th width="13%" class="text-center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$reports->isEmpty())
                    @foreach($reports as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td class="text-center">
                                @if($r->image)
                                    <a href="{{ asset('storage'.$r->image) }}" download>
                                        <img src="{{ asset('storage'.$r->image) }}" height="30" width="30">
                                    </a>
                                @endif
                            </td>
                            <td>{{ $r->name }}</td>
                            <td class="text-center">{{ $r->emp_number }}</td>
                            <td>{{ setDate($r->date) }}</td>
                            <td>{{ $r->description }}</td>
                            <td>{{ $r->location }}</td>
                            <td>{{ $r->time }}</td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ route('monitorings.reports.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['destroy']))
                                    <button href="{{ route('monitorings.reports.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($reports) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
