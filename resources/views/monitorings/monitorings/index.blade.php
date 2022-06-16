@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Cari .."/>
                <x-form.select name="filterLocation" class="mr-1" options="- Pilih Lokasi Kerja -" :datas="$locations" value="{{ $filterLocation ?? '' }}"/>
                <x-form.select-month name="filterMonth" class="mr-1" event="document.getElementById('form').submit();" value="{{ $filterMonth }}"/>
                <x-form.select-year name="filterYear" class="mr-1" event="document.getElementById('form').submit();" value="{{ $filterYear }}"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['export']))
                <a href="{{ route('monitorings.monitorings.export', ['filter' => $filter, 'filterLocation' => $filterLocation, 'filterMonth' => $filterMonth, 'filterYear' => $filterYear]) }}" class="btn btn-success">
                    <i data-feather='file'></i> Export Data
                </a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th rowspan="2" class="align-middle text-center" style="min-width: 20px;">No</th>
                    <th rowspan="2" class="align-middle text-center" style="min-width: 200px;">Nama</th>
                    <th rowspan="2" class="align-middle text-center" style="min-width: 100px;">NIK</th>
                    <th colspan="{{ $totalDays }}" class="text-center" style="min-width: 1400px;">{{ numToMonth($filterMonth) }} {{ $filterYear }}</th>
                </tr>
                <tr>
                    @for($i = 1; $i<= $totalDays; $i++)
                        <th style="min-width: 50px;" class="text-center">{{ $i }}</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @if(!$employees->isEmpty())
                    @foreach($employees as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td class="text-center">{{ $r->emp_number }}</td>
                            @for($i = 1; $i<= $totalDays; $i++)
                                @php
                                    $totalMonitoring = isset($monitorings[$r->id][$i]) ? $monitorings[$r->id][$i]."/7" : '';
                                @endphp
                                <td class="text-center" style="min-width: 30px;">
                                    @if($totalMonitoring)
                                        <a href="{{ route('monitorings.monitorings.show', [$r->id, $i, 'filterMonth' => $filterMonth, 'filterYear' => $filterYear]) }}">
                                            {{ $totalMonitoring }}
                                        </a>
                                    @else

                                    @endif
                                </td>
                            @endfor
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
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
        {{ generatePagination($employees) }}

    </div>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
