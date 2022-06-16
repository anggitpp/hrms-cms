@extends('app')
@section('content')
    <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($plan) ? route('recruitments.plans.store') : route('recruitments.plans.update', $plan->id) }}">
        @csrf
        @if(!empty($plan))
            @method('PATCH')
        @endif
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Kebutuhan</h4>
                <div>
                    <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                        Simpan
                    </button>
                    <a href="{{ route('recruitments.plans.index') }}" class="btn btn-outline-secondary mr-1">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor Kebutuhan" required name="plan_number" readonly value="{{ $plan->plan_number ?? $planNumber }}"/>
                        <x-form.input label="Judul" required name="title" value="{{ $plan->title ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Pengajuan" required name="propose_date" value="{{ $plan->propose_date ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Diajukan Oleh" required name="employee_id" options="- Pilih Pegawai -" :datas="$employees" value="{{ $plan->employee_id ?? '' }}"/>
                        <x-form.select label="Posisi" required name="position_id" options="- Pilih Posisi -" :datas="$positions" value="{{ $plan->position_id ?? '' }}" />
                        <x-form.datepicker label="Tanggal Kebutuhan" required name="need_date" value="{{ $plan->need_date ?? '' }}"/>
                    </div>
                </div>
            </div>
            <div class="card-header" style="margin-top: -30px;">
                <h4 class="card-title">Data Rekrutmen</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Minimal Pendidikan" required name="education_id" options="- Pilih Pendidikan -" :datas="$education" value="{{ $plan->education_id ?? '' }}" />
                        <x-form.double-input label="Umur Dari" numeric label2="Umur Sampai" name="age_from" name2="age_to" value="{{ $plan->age_from ?? '' }}" value2="{{ $plan->age_to ?? '' }}"/>
                        <x-form.input label="Minimum Experience" name="experience" class="col-md-6" value="{{ $plan->experience ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Lokasi" required name="location_id" options="- Pilih Lokasi -" :datas="$locations" value="{{ $plan->location_id ?? '' }}" />
                        <x-form.radio label="Jenis Kelamin" :datas="$genders" name="gender" value="{{ $plan->gender ?? '' }}"/>
                        <x-form.input label="Jumlah Orang" name="number_of_people" numeric class="col-md-2" value="{{ $plan->number_of_people ?? '' }}" />
                    </div>
                </div>
                <x-form.textarea label="Catatan" name="notes" value="{{ $plan->notes ?? '' }}" />
                <x-form.textarea label="Alasan Perekrutan" name="recruitment_reason" value="{{ $plan->recruitment_reason ?? '' }}" />
                <div class="row">
                    <div class="col-md-6">
                        <x-form.file label="File" name="filename" value="{{ $plan->filename ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.radio label="Status" name="status" :datas="$listStatus" value="{{ $plan->status ?? '' }}"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
