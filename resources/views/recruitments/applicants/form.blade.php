@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ route('recruitments.applicants.index') }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($appl) ? route('recruitments.applicants.store') : route('recruitments.applicants.update', $appl->id) }}">
                @csrf
                @if(!empty($appl))
                    @method('PATCH')
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input label="Nomor Pelamar" readonly name="applicant_number" required placeholder="Nomor Pelamar" value="{{ $appl->applicant_number ?? $applicantNumber }}"/>
                        <x-form.input label="Nama" name="name" required placeholder="Nama" value="{{ $appl->name ?? '' }}"/>
                        <x-form.input label="Tempat Lahir" name="birth_place" required placeholder="Tempat Lahir" value="{{ $appl->birth_place ?? '' }}"/>
                        <x-form.select label="Agama" name="religion_id" required :datas="$masters['SAG']" options="- Pilih Agama -" value="{{ $appl->religion_id ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.select label="Kebutuhan" name="plan_id" required :datas="$plans" options="- Pilih Kebutuhan -" value="{{ $appl->plan_id ?? '' }}" />
                        <x-form.input label="Alias" name="nickname" placeholder="Alias" value="{{ $appl->nickname ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Lahir" required name="birth_date" value="{{ $appl->birth_date ?? '' }}" class="col-md-6" />
                        <x-form.input label="Email" name="email" placeholder="Email" value="{{ $appl->email ?? '' }}"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.datepicker label="Tanggal Input" required name="input_date" value="{{ $appl->input_date ?? date('Y-m-d') }}" class="col-md-6" />
                        <x-form.input label="Nomor KTP" required numeric maxlength="16" name="identity_number" placeholder="Nomor KTP" value="{{ $appl->identity_number ?? '' }}"/>
                        <x-form.radio label="Jenis Kelamin" name="gender" :datas="$gender" value="{{ $appl->gender ?? '' }}" />
                        <x-form.select label="Status Perkawinan" name="marital_id" :datas="$masters['ESK']" options="- Pilih Status Perkawinan -" value="{{ $appl->marital_id ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.textarea label="Alamat Domisili" name="address" value="{{ $appl->address ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.textarea label="Alamat KTP" name="identity_address" value="{{ $appl->identity_address ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.select label="Golongan Darah" name="blood_type" :datas="$bloodTypes" options="- Pilih Golongan Darah -" value="{{ $appl->blood_type ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input label="Nomor Telp" numeric name="phone" placeholder="Nomor Telp" value="{{ $appl->phone ?? '' }}"/>
                        <x-form.input label="Berat Badan (kg)" numeric name="weight" placeholder="Berat Badan" value="{{ $appl->weight ?? '' }}" class="col-md-4"/>
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Nomor Handphone" numeric name="mobile_phone" placeholder="Nomor Handphone" value="{{ $appl->mobile_phone ?? '' }}"/>
                        <x-form.file label="Foto" imageOnly name="photo" value="{{ $appl->photo ?? '' }}" />
                    </div>
                    <div class="col-md-4">
                        <x-form.input label="Tinggi Badan (cm)" numeric name="height" placeholder="Tinggi Badan" value="{{ $appl->height ?? '' }}" class="col-md-4"/>
                        <x-form.file label="File KTP" imageOnly name="identity_file" value="{{ $appl->identity_file ?? '' }}" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
