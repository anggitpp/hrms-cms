@extends('app')
@section('content')
    @php
        $url = '/bms/'.$arrMenu['target'].'/object/';
    @endphp
    <div class="card">
        <!-- PROFILE -->
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="row justify-content-between">
                &nbsp;
                <img class="img-fluid rounded" src="{{ asset( $building->photo ? 'storage/'.$building->photo : 'storage/nophoto.png') }}" height="150" width="150" style="max-width:100%;max-height:100%;" alt="User avatar"/>
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
                <h4>Data Objek</h4>
            </div>
            <div class="form-inline">
                @if(isset($access['area/create']))
                    <a href="{{ route('bms.'.$arrMenu['target'].'.object.create', $id) }}" class="btn btn-primary"><i data-feather='plus'></i> Tambah Objek</a>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Nama</th>
                    <th width="19%">Kategori</th>
                    <th width="5%">Aktifitas</th>
                    <th width="5%">QR</th>
                    <th width="12%">Shift</th>
                    <th width="3%">Order</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="13%">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$objects->isEmpty())
                    @foreach($objects as $key => $r)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $masters['BOB'][$r->object_id] }}</td>
                            <td align="center">
                                <a href="#" class="btn-modal-form" data-toggle="modal" data-action="activities" data-url="{{ $url }}" data-id="{{ $r->id }}">
                                    {{ $totalActivities[$r->object_id] ?? 0 }}
                                </a>
                            </td>
                            <td>
                                @if($r->qr == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td>{{ $r->shift == 't' ? 'Shift Gedung' : 'Shift Khusus' }}</td>
                            <td align="right">{{ $r->order }}</td>
                            <td>
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                            <td align="center">
                                @if(isset($access['object/edit']))
                                    <a href="{{ route('bms.'.$arrMenu['target'].'.object.edit', $r->id) }}" class="btn btn-icon btn-primary"><i data-feather="edit"></i></a>
                                @endif
                                @if(isset($access['object/destroy']))
                                    <button href="{{ route('bms.'.$arrMenu['target'].'.object.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
    <x-modal-form title="List Aktifitas" size="modal-lg"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
