@extends('app')
@section('content')
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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($target) ? route('bms.targets.store') : route('bms.targets.update', $target->id) }}">
                @csrf
                @if(!empty($target))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Sasaran</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Layanan" required name="service_id" :datas="$masters['BLY']" options="- Pilih Layanan -" value="{{ $target->service_id ?? $selectedService }}" event="getSub(this.value, 'object_id');"/>
                        <x-form.input label="Nama" name="name" required placeholder="Nama" value="{{ $target->name ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Obyek" required name="object_id" :datas="$objects" options="- Pilih Obyek -" value="{{ $target->object_id ?? '' }}"/>
                        <x-form.input label="Kode" name="code" readonly value="{{ $target->code ?? $lastCode }}"/>
                    </div>
                </div>
                <x-form.textarea label="Description" name="description" value="{{ $target->description ?? '' }}" />
                <div class="row">
                    <div class="col-md-6">
                    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $target->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Urutan" class="col-md-2" style="text-align: right" name="order" readonly value="{{ $target->order ?? 1 }}"/>
                    </div>
            </form>
        </div>
    </div>
@endsection
