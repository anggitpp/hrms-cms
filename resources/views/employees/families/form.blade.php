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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($family) ? route('employees.families.store') : route('employees.families.update', $family->id) }}">
                @csrf
                @if(!empty($family))
                    @method('PATCH')
                @endif
                @php
                if(!empty($family))
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
                        <x-form.select label="Nama Pegawai" name="employee_id" required :datas="$employees" options="- Pilih Pegawai -" value="{{ $family->employee_id ?? '' }}" />
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="NIK Pegawai" name="emp_number" readonly value="{{ $emp->emp_number ?? '' }}"/>
                        <x-form.input label="Pangkat" name="rank_id" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Keluarga</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" required name="name" value="{{ $family->name ?? '' }}"/>
                        <x-form.input label="Tempat Lahir" name="birth_place" placeholder="Tempat Lahir" value="{{ $family->birth_place ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Hubungan" name="relation_id" required :datas="$masters['EHK']" options="- Pilih Hubungan -" value="{{ $family->relation_id ?? '' }}" />
                        <x-form.datepicker label="Tanggal Lahir" name="birth_date" value="{{ $family->birth_date ??'' }}" class="col-md-6" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="No. KTP" maxlength="16" numeric name="identity_number" value="{{ $family->identity_number ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.radio label="Jenis Kelamin" name="gender" :datas="$gender" value="{{ $family->gender ?? '' }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.file label="Foto" name="filename" value="{{ $family->filename ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Keterangan" name="description" placeholder="Keterangan" value="{{ $family->description ?? '' }}"/>
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
