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
                    <th width="15%">Nama</th>
                    <th width="25%">Rencana</th>
                    <th width="15%">Posisi</th>
                    <th width="15%">Waktu</th>
                    <th width="10%">Hasil</th>
                    <th width="5%">File</th>
                    <th style="text-align: center" width="5%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$selections->isEmpty())
                    @foreach($selections as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>
                                {{ $r->name }}<br>
                                <i><b>{{ $r->applicant_number }}</b></i>
                            </td>
                            <td>{{ $r->title }}</td>
                            <td>{{ $r->position }}</td>
                            <td>{{ $r->selection_date ? setDate($r->selection_date).' '.(Str::substr($r->selection_time, 0, 5) ?? '') : '' }}</td>
                            <td>
                                @if($r->result == 't')
                                    <div class="badge badge-success">Lulus</div>
                                @elseif($r->result == 'f')
                                    <div class="badge badge-danger">Tidak Lulus</div>
                                @else
                                @endif
                            </td>
                            <td align="center">
                                @if($r->filename)
                                    <a href="{{ asset('storage'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                                @endif
                            </td>
                            <td align="center">
                                 @if(isset($access['edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id ?? $r->applId }}"
                                       data-url="{{ $url }}" data-action="{{ $r->id ? 'edit' : 'create' }}">
                                        <i data-feather="edit"></i>
                                    </a>
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
            {{ generatePagination($selections) }}
        </div>
    </div>
    <x-side-modal-form title="Form Menu"/>
@endsection
