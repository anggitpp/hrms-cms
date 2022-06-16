@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($work) ? route('employees.works.store') : route('employees.works.update', $work->id) }}">
                @csrf
                @if(!empty($work))
                    @method('PATCH')
                @endif
                @php
                if(!empty($work))
                    if(!empty($emp)){
                        $position = $masters['EJP'][$emp->contract->position_id];
                        $rank = $masters['EP'][$emp->contract->rank_id];
                    }
                @endphp
                <div class="card-title">
                    <h5>Data Pegawai</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Nama Pegawai" name="employee_id" required :datas="$employees" options="- Pilih Pegawai -" value="{{ $work->employee_id ?? '' }}" />
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="NIK Pegawai" name="emp_number" readonly value="{{ $emp->emp_number ?? '' }}"/>
                        <x-form.input label="Pangkat" name="rank_id" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Riwayat Kerja</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Perusahaan" required name="company" placeholder="Perusahaan" value="{{ $work->company ?? '' }}" />
                        <x-form.datepicker label="Tgl Mulai" class="col-md-12" required name="start_date" value="{{ $work->start_date ?? '' }}" />
                        <x-form.input label="Kota" name="city" placeholder="City" value="{{ $work->city ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Posisi" required name="position" placeholder="Posisi" value="{{ $work->position ?? '' }}" />
                        <x-form.datepicker label="Tgl Selesai" class="col-md-12" name="end_date" value="{{ $work->end_date ?? '' }}" />
                        <x-form.file label="File" name="filename" value="{{ $work->filename ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.textarea label="Uraian Tugas" name="job_desc" value="{{ $work->job_desc ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.textarea label="Keterangan" name="description" value="{{ $work->description ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#employee_id').on('change', function (){
            $.ajax({
                url: 'getDetail/'+ this.value,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#emp_number').val(data['emp_number']);
                    $('#position_id').val(data['positionName']);
                    $('#rank_id').val(data['rankName']);
                },
            });
        });
    </script>
@endsection
