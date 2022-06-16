@extends('app')
@section('content')
    @php
        $url = '/recruitments/'.$arrMenu['target']."/";
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select name="filterPlan" class="mr-1" options="- Pilih Rencana -" :datas="$plans" value="{{ $filterPlan ?? '' }}" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="20%">Nama</th>
                    <th width="25%">Rencana</th>
                    <th width="15%">Posisi</th>
                    <th width="15%">Tgl Mulai</th>
                    <th width="15%">Tgl Selesai</th>
                    <th width="5%">File</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="5%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$contracts->isEmpty())
                    @foreach($contracts as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>
                                {{ $r->name }}<br>
                                <i><b>{{ $r->applicant_number }}</b></i>
                            </td>
                            <td>{{ $r->title }}</td>
                            <td>{{ $r->position }}</td>
                            <td>{{ $r->start_date ? setDate($r->start_date) : '' }}</td>
                            <td>{{ $r->end_date ? setDate($r->end_date) : '' }}</td>
                            <td align="center">
                                @if($r->filename)
                                    <a href="{{ asset('storage'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                                @endif
                            </td>
                            <td>
                                @if($r->status == 't')
                                    <div class="badge badge-success">Disetujui</div>
                                @elseif($r->status == 'f')
                                    <div class="badge badge-danger">Ditolak</div>
                                @else
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="{{ $r->id ? route('recruitments.contracts.edit', $r->id) : route('recruitments.contracts.create', $r->applId) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
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
            {{ generatePagination($contracts) }}
        </div>
    </div>
    <x-side-modal-form title="Form Menu"/>
    <style>
        .select2{
            min-width: 250px;
        }
    </style>
@endsection
