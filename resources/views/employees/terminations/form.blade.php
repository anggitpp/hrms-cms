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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($termination) ? route('employees.terminations.store') : route('employees.terminations.update', $termination->id) }}">
                @csrf
                @if(!empty($termination))
                    @method('PATCH')
                @endif
                @php
                if(!empty($termination))
                    if(!empty($emp)){
                        $position = $masters['EJP'][$emp->contract->position_id];
                        $join_date = setDate($emp->join_date);
                    }
                @endphp
                <div class="card-title">
                    <h5>Data Pegawai</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor Termination" required name="termination_number" readonly value="{{ $termination->termination_number ?? $terminationNumber }}"/>
                        <x-form.select label="Nama Pegawai" name="employee_id" required :datas="$employees" options="- Pilih Pegawai -" value="{{ $termination->employee_id ?? '' }}" />
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal" class="col-md-12" required name="date" value="{{ $termination->date ?? date('Y-m-d') }}" />
                        <x-form.input label="NIK Pegawai" name="emp_number" readonly value="{{ $emp->emp_number ?? '' }}"/>
                        <x-form.input label="Tanggal Masuk" name="join_date" readonly value="{{ $join_date ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Termination</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Kategori" required name="category_id" :datas="$masters['ESP']" options="- Pilih Kategori -" value="{{ $termination->category_id ?? '' }}" />
                        <x-form.textarea label="Deskripsi" name="description" value="{{ $termination->description ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Efektif" class="col-md-12" required name="effective_date" value="{{ $termination->effective_date ?? '' }}" />
                        <x-form.file label="File" name="filename" value="{{ $termination->filename ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.textarea label="Catatan" name="note" value="{{ $termination->note ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
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
                    $('#join_date').val(data['joinDate']);
                },
            });
        });
    </script>
@endsection
