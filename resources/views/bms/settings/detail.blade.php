@extends('app')
@section('content')
    @php
        $url = '/bms/'.$arrMenu['target'].'/';
    @endphp
    <div class="card">
        <!-- PROFILE -->
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="row justify-content-center">
                <img class="img-fluid rounded" src="{{ asset( $building->photo ? 'storage/'.$building->photo : 'storage/nophoto.png') }}" height="150" width="150" style="max-width:100%;max-height:100%;" alt="User avatar"/>
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
                <h4>Data Area Kerja</h4>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="*">Area</th>
                    <th width="5%">Kode</th>
                    <th width="13%">Shift</th>
                    <th width="20%">Kategori</th>
                    <th width="5%">Aktifitas</th>
                    <th width="5%">Status</th>
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
                                <a href="#" class="btn-modal-form" data-toggle="modal" data-action="shift" data-url="{{ $url }}" data-id="{{ $r->id }}">
                                    {{ $r->shift == "t" ? "Shift Gedung" : "Shift Khusus" }}
                                </a>
                            </td>
                            <td>{{ $r->end }}</td>
                            <td></td>
                            <td align="center">
                                @if($r->status == 't')
                                    <div class="badge badge-success">Aktif</div>
                                @else
                                    <div class="badge badge-danger">Tidak Aktif</div>
                                @endif
                            </td>
                        </tr>
                        @if(!$r->objects->isEmpty())
                            @foreach($r->objects as $k => $object)
                                <tr>
                                    <td></td>
                                    <td><span style="margin-left: 20px;">{{ strtolower(numToAlpha($k)).". ". $object->name }}</span></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $masters['BOB'][$object->object_id] }}</td>
                                    <td align="center">
                                        <a href="#" class="btn-modal-form" data-toggle="modal" data-action="activities" data-url="{{ $url }}" data-id="{{ $object->id }}">
                                            {{ $totalActivities[$object->object_id] ?? 0 }}
                                        </a>
                                    </td>
                                    <td align="center">
                                        <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
    <x-side-modal-form title="Form Shift"/>
    <x-modal-form title="List Aktifitas" size="modal-lg"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
