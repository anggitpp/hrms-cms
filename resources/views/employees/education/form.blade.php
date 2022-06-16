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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($edu) ? route('employees.education.store') : route('employees.education.update', $edu->id) }}">
                @csrf
                @if(!empty($edu))
                    @method('PATCH')
                @endif
                @php
                if(!empty($edu))
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
                        <x-form.select label="Nama Pegawai" name="employee_id" required :datas="$employees" options="- Pilih Pegawai -" value="{{ $edu->employee_id ?? '' }}" />
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="NIK" name="emp_number" readonly value="{{ $emp->emp_number ?? '' }}"/>
                        <x-form.input label="Pangkat" name="rank_id" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Education Data</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Tingkatan" required name="level_id" :datas="$masters['SPD']" options="- Pilih Pendidikan -" value="{{ $edu->level_id ?? '' }}" />
                        <x-form.input label="Jurusan" name="major" placeholder="Jurusan" value="{{ $edu->major ?? '' }}" />
                        <x-form.input label="Tahun Mulai" required maxlength="4" numeric name="start_year" placeholder="Tahun Mulai" value="{{ $edu->start_year ?? '' }}" />
                        <x-form.input label="Kota" name="city" placeholder="Kota" value="{{ $edu->city ?? '' }}" />
                        <x-form.textarea label="Keterangan" name="description" value="{{ $edu->description ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Lembaga" required name="name" placeholder="Lembaga" value="{{ $edu->name ?? '' }}" />
                        <x-form.input label="Nilai" name="score" placeholder="Nilai" value="{{ $edu->score ?? '' }}" />
                        <x-form.input label="Tahun Selesai" maxlength numeric name="end_year" placeholder="Tahun Selesai" value="{{ $edu->end_year ?? '' }}" />
                        <x-form.input label="Essay" name="essay" placeholder="Essay" value="{{ $edu->essay ?? '' }}"/>
                        <x-form.file label="File" name="filename" value="{{ $edu->filename ?? '' }}"/>
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
