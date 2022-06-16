@extends('app')
@section('content')
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
                    <th width="15%">Posisi</th>
                    <th width="15%">Pangkat</th>
                    <th width="15%">Penempatan</th>
                    <th width="15%">Lokasi</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="5%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$placements->isEmpty())
                    @foreach($placements as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>
                                {{ $r->name }}<br>
                                <i><b>{{ $r->applicant_number }}</b></i>
                            </td>
                            <td>{{ $r->position }}</td>
                            <td>{{ $r->rank_id ? $masters['EP'][$r->rank_id] : '' }}</td>
                            <td>{{ $r->placement_id ? $placement[$r->placement_id]  : '' }}</td>
                            <td>{{ $r->location_id ? $masters['ELK'][$r->location_id]  : '' }}</td>
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
                                    <a href="{{ $r->id ? route('recruitments.placements.edit', $r->id) : route('recruitments.placements.create', $r->contractId) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
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
            {{ generatePagination($placements) }}
        </div>
    </div>
    <x-side-modal-form title="Form Menu"/>
    <style>
        .select2{
            min-width: 250px;
        }
    </style>
@endsection
