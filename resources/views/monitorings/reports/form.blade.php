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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('monitorings.reports.update', $report->id) }}">
                @csrf
                @if(!empty($report))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Laporan/Temuan</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" name="name" value="{{ $report->employee->name }}" readonly/>
                        <x-form.datepicker label="Tanggal" name="date" value="{{ $report->date ?? '' }}"/>
                        <x-form.textarea label="Keterangan" name="description" value="{{ $report->description ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="NIK" name="emp_number" class="col-md-4" readonly value="{{ $report->employee->emp_number }}"/>
                        <x-form.timepicker label="Waktu" name="time" value="{{ $report->time ?? '' }}"/>
                        <x-form.input label="Lokasi" name="location" value="{{ $report->location ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
