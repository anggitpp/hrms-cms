@php
    $url = '/payrolls/'.$arrMenu['target'].'/';
@endphp
@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <div class="form-inline">
                <a href="#" data-url="{{ $url }}" data-action="import" data-id="{{ $month."/".$year }}" class="btn btn-primary btn-modal-form ml-2"><i data-feather='repeat'></i> Upload {{ $arrMenu['name'] }} - {{ numToMonth($month)." ".$year }}</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Nama</th>
                    <th width="20%" class="text-center">NIK</th>
                    <th width="10%">Nilai</th>
                </tr>
                </thead>
                <tbody>
                @if(!$details->isEmpty())
                    @foreach($details as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $r->name }}</td>
                        <td class="text-center">{{ $r->emp_number }}</td>
                        <td class="text-right">{{ setCurrency($r->value) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            {{ generatePagination($details) }}
        </div>
    </div>
    <x-modal-form title="Upload {{ $arrMenu['name'] }} "/>
@endsection
