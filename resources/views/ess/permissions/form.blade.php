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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($permission) ? route('ess.permissions.store') :
            (str_contains(Request::route()->getName(), 'approve') ? route('ess.permissions.approve.update', $permission->id) : route('ess.permissions.update', $permission->id)) }}">
                @csrf
                @if(!empty($permission))
                    @method('PATCH')
                @endif
                @php
                    if(!empty($emp)){
                        $position = $masters['EJP'][$emp->contract->position_id];
                        $rank = $masters['EP'][$emp->contract->rank_id];
                    }
                @endphp
                <div class="card-title">
                    <h5>Data Pegawai</h5>
                    <hr>
                </div>
                <input type="hidden" id="employee_id" name="employee_id" value="{{ $permission->employee_id ?? Auth::user()->employee_id }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $permission->number ?? $permissionNumber }}"/>
                        <x-form.input label="Nama Pegawai" name="name" readonly value="{{ $emp->name ? $emp->name : '' }}"/>
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $permission->date ?? date('Y-m-d') }}" class="col-md-4"/>
                        <x-form.input label="NIK" name="nik" readonly value="{{ $emp->emp_number ? $emp->emp_number : '' }}"/>
                        <x-form.input label="Pangkat" name="rank_id" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Izin</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Kategori Izin" name="category_id" required :datas="$categories" options="- Pilih Kategori Izin -" value="{{ $permission->category_id ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $permission->start_date ??'' }}" class="col-md-4"/>
                        <x-form.file label="File Pendukung" name="filename" value="{{ $permission->filename ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Keterangan" name="description" placeholder="Keterangan" value="{{ $permission->description ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Selesai" required name="end_date"value="{{ $permission->end_date ??'' }}" class="col-md-4" />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection