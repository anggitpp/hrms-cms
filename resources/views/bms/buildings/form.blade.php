@extends('app')
@section('content')
{{--    @dd($building->id)--}}
    <div class="card">
        <div class="card-header">
            &nbsp;
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($building) ? route('bms.buildings.store') : route('bms.buildings.update', $building->id) }}">
                @csrf
                @if(!empty($building))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Gedung</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" name="name" required placeholder="Nama" value="{{ $building->name ?? '' }}"/>
                        @if(Session::get('sessionBuilding'))
                            <x-form.input label="Wilayah" name="regionName" readonly value="{{ $sessionBuilding->regionName }}"/>
                            <input type="hidden" name="region_id" value="{{ $sessionBuilding->regionId }}"/>
                        @else
                            <x-form.select label="Wilayah" required name="region_id" :datas="$masters['ELK']" options="- Pilih Wilayah -" value="{{ $building->region_id ?? '' }}"/>
                        @endif
                        <x-form.textarea label="Alamat" name="address" value="{{ $building->address ?? '' }}" />
                        <x-form.radio label="Status" required name="status" :datas="$status" value="{{ $building->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Kode" required name="code" readonly value="{{ $building->code ?? $lastCode }}"/>
                        <x-form.select label="Tipe" required name="type_id" :datas="$masters['BTP']" options="- Pilih Tipe -" value="{{ $building->type_id ?? '' }}"/>
                        <x-form.file label="Foto" imageOnly name="photo" value="{{ $building->photo ?? '' }}" />
                    </div>
                </div>
                <br>
                <table class="table table-striped table-borderless" style="width: 30%;">
                    <thead class="thead-light">
                    <tr>
                        <th>Layanan</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($masters['BLY'] as $key => $value)
                        @php
                            $checked = "";
                            if(!empty($listServices)){
                                if(in_array($key, $listServices))
                                    $checked = "checked";
                            }
                        @endphp
                        <tr>
                            <td>{{ $value }}</td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="{{ $key }}" name="services[{{ $key }}]" id="services[{{ $key }}]"
                                        {!! $checked !!} />
                                    <label class="custom-control-label" for="services[{{ $key }}]"></label>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection
