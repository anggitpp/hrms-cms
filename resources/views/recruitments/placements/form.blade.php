@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ route('recruitments.placements.index') }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($placement) ? route('recruitments.placements.store', $contract->id) : route('recruitments.placements.update', $placement->id) }}">
                @csrf
                @if(!empty($placement))
                    @method('PATCH')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" readonly name="" value="{{ $appl->name }}"/>
                        <x-form.select label="Pangkat" required name="rank_id" :datas="$masters['EP']" event="getSub(this.value, 'grade_id');" options="- Pilih Pangkat -" value="{{ $placement->rank_id ?? '' }}" />
                        <x-form.select label="Penempatan" required name="placement_id" :datas="$placements" options="- Pilih Penempatan -" value="{{ $placement->placement_id ?? '' }}" />
                        <x-form.select label="Jenis Payroll" required name="payroll_id" :datas="$masters['EJPR']" options="- Pilih Jenis Payroll -" value="{{ $placement->payroll_id ?? '' }}" />
                        <x-form.select label="Bank" name="bank_id" :datas="$masters['SB']" options="- Pilih Bank -" value="{{ $placement->bank_id ?? '' }}" />
                        <x-form.input label="Nama Pemilik Rekening" name="account_name" placeholder="Nama Pemilik Rekening" value="{{ $placement->account_name ?? '' }}"/>
                        <x-form.file label="File" name="filename" value="{{ $placement->filename ?? '' }}" />
                        <x-form.radio label="Status" name="status" :datas="$statusApprove" value="{{ $placement->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Posisi" readonly name="" value="{{ $appl->position }}"/>
                        <x-form.select label="Grade" name="grade_id" :datas="$masters['EG']" options="- Pilih Grade -" value="{{ $placement->grade_id ?? '' }}" />
                        <x-form.select label="Lokasi Kerja" required name="location_id" :datas="$masters['ELK']" options="- Pilih Lokasi Kerja -" value="{{ $placement->location_id ?? '' }}" />
                        <x-form.select label="Shift" name="shift_id" :datas="$shifts" options="- Pilih Shift -" value="{{ $placement->shift_id ?? '' }}" />
                        <x-form.input label="Nomor Rekening" name="account_number" placeholder="Nomor Rekening" value="{{ $placement->account_number ?? '' }}"/>
                        <x-form.input label="Deskripsi" name="description" placeholder="Deskripsi" value="{{ $placement->description ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
