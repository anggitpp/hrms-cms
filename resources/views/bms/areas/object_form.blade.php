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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($object) ? route('bms.'.$arrMenu['target'].'.object.store', $id) : route('bms.'.$arrMenu['target'].'.object.update', $object->id) }}">
                @csrf
                @if(!empty($object))
                    @method('PATCH')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Kategori" name="object_id" required :datas="$categories" options="- Pilih Kategori -" value="{{ $object->object_id ?? '' }}"/>
                        <x-form.select label="PIC" name="employee_id" :datas="$employees" options="- Pilih PIC -" value="{{ $object->employee_id ?? '' }}"/>
                        <x-form.textarea label="Keterangan" name="description" value="{{ $object->description ?? '' }}"/>

                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Nama" required name="name" placeholder="Nama" value="{{ $object->name ?? '' }}" />
                        <x-form.input label="Kode" name="code" placeholder="Kode" readonly value="{{ $object->code ?? $lastCode }}" />
                        <x-form.input label="Urutan" name="order" value="{{ $object->order ?? $lastOrder + 1 }}" class="col-md-2" numeric />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.radio label="Shift" name="shift" :datas="$shiftOption" value="{{ $object->finish_today ?? '' }}"/>
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $object->status ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.radio label="QR" name="qr" :datas="$status" value="{{ $object->qr ?? '' }}"/>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
