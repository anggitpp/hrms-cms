@extends('app')
@section('content')
    @php
        $url = '/bms/'.$arrMenu['target'].'/shift/';
    @endphp
    <div class="card">
        <!-- PROFILE -->
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="row justify-content-between">
                &nbsp;
                <img class="img-fluid rounded" src="{{ asset( $building->photo ? 'storage/'.$building->photo : 'storage/nophoto.png') }}" height="150" width="150" style="max-width:100%;max-height:100%;" alt="User avatar"/>
                <a href="{{ route('bms.'.$arrMenu['target'].'.areas', $building->id) }}" style="height: 40px;" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
            <br>
            <div class="row justify-content-center">
                <h4>{{ $building->name }} <span style="color: darkgray; font-size: 15px;"> ({{ $building->code }})</span></h4>
            </div>
            <div class="row justify-content-center">
                <h6><i>{{ $building->address }}</i></h6>
            </div>
            <div class="row justify-content-center">
                <h6><i>{{ $masters['ELK'][$building->region_id] }}</i></h6>
            </div>
        </div>
        <div class="card-header justify-content-between">
            <div class="card-title">
                <h4>Data Shift Khusus - {{ $area->name }}</h4>
            </div>
            <div class="form-inline">
                @if(isset($access['shift/create']))
                    <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="create" data-url="{{ $url }}" data-id="{{ $id }}">
                        <i data-feather='plus'></i> Tambah Shift
                    </button>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="*">Nama</th>
                        <th width="10%">Code</th>
                        <th width="10%">Start</th>
                        <th width="10%">End</th>
                        <th width="10%">Durasi</th>
                        <th width="5%">Status</th>
                        <th style="text-align: center" width="13%">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                @if(!$shifts->isEmpty())
                    @foreach($shifts as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $r->start }}</td>
                            <td>{{ $r->end }}</td>
                            <td>{{ $masters['BKIV'][$r->interval_id] }}</td>
                            <td align="center">
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['shift/edit']))
                                    <a href="#" data-toggle="modal" data-action="edit" data-url="{{ $url }}" data-id="{{ $r->id }}" class="btn btn-icon btn-primary btn-modal"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['shift/destroy']))
                                    <button href="{{ route('bms.'.$arrMenu['target'].'.shift.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Objek"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
