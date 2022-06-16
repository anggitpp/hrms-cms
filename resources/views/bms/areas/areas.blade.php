@extends('app')
@section('content')
    @php
    $url = '/bms/'.$arrMenu['target'].'/area/';
    @endphp
    <div class="card">
        <!-- PROFILE -->
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="row justify-content-between">
                &nbsp;
                <img class="img-fluid rounded" src="{{ asset( $building->photo ? 'storage/'.$building->photo : 'storage/uploads/images/nophoto.png') }}" height="150" width="150" style="max-width:100%;max-height:100%;" alt="User avatar"/>
                &nbsp;
            </div>
            <a href="{{ url()->previous() }}" style="height: 40px; position: absolute; top: 5px; right: 10px;" class="btn btn-outline-secondary mr-1">Kembali</a>
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
                <h4>Data Area</h4>
            </div>
            @if(isset($access['area/create']))
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="create" data-url="{{ $url }}" data-id="{{ $building->id }}">
                <i data-feather='plus'></i> Tambah Area
            </button>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Nama</th>
                    <th width="10%">Kode</th>
                    <th width="15%">Shift</th>
                    <th width="10%">Objek</th>
                    <th width="10%">Order</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$areas->isEmpty())
                    @foreach($areas as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->code }}</td>
                            <td>
                                @if($r->shift == "t")
                                    <a href="#" class="btn-modal-form" data-toggle="modal" data-action="shifts" data-url="{{ $url }}" data-id="{{ $r->id }}">Shift Gedung</a>
                                @else
                                    <a href="{{ route('bms.'.$arrMenu['target'].'.shifts', $r->id) }}">Shift Khusus</a>
                                @endif
                            </td>
                            <td align="right"><a href="{{ route('bms.'.$arrMenu['target'].'.objects', $r->id) }}"> {{ $totalObjects[$r->id] ?? 0 }}</a></td>
                            <td align="right">{{ $r->order }}</td>
                            <td>
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['area/edit']))
                                    <a href="#" data-toggle="modal" data-action="edit" data-url="{{ $url }}" data-id="{{ $r->id }}" class="btn btn-icon btn-primary btn-modal"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['area/destroy']))
                                    <button href="{{ route('bms.'.$arrMenu['target'].'.area.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
    <x-side-modal-form title="Form Area"/>
    <x-modal-form title="List Shift" size="modal-lg"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
