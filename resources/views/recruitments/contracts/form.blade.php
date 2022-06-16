@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ route('recruitments.contracts.index') }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($contract) ? route('recruitments.contracts.store', $appl->id) : route('recruitments.contracts.update', $contract->id) }}">
                @csrf
                @if(!empty($contract))
                    @method('PATCH')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" readonly name="" value="{{ $appl->name }}"/>
                        <x-form.select label="Tipe Pegawai" required name="type_id" :datas="$types" options="- Pilih Tipe Pegawai -" value="{{ $contract->type_id ?? '' }}" />
                        <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $contract->start_date ?? '' }}" class="col-md-4" />
                        <x-form.file label="File" name="filename" value="{{ $contract->filename ?? '' }}" />
                        <x-form.radio label="Status" name="status" :datas="$statusApprove" value="{{ $contract->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Posisi" readonly name="" value="{{ $appl->position }}"/>
                        <x-form.input label="Nomor SK" name="sk_number" placeholder="Nomor SK" value="{{ $contract->sk_number ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Selesai" name="end_date" value="{{ $contract->end_date ?? '' }}" class="col-md-4" />
                        <x-form.input label="Deskripsi" name="description" placeholder="Deskripsi" value="{{ $contract->description ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
