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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($reimbursement) ? route('ess.reimbursements.store') :
            (str_contains(Request::route()->getName(), 'approve') ? route('ess.reimbursements.approve.update', $reimbursement->id) : route('ess.reimbursements.update', $reimbursement->id)) }}">
                @csrf
                @if(!empty($reimbursement))
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
                <input type="hidden" id="employee_id" name="employee_id" value="{{ $reimbursement->employee_id ?? Auth::user()->employee_id }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $reimbursement->number ?? $reimbursementNumber }}"/>
                        <x-form.input label="Nama Pegawai" name="name" readonly value="{{ $emp->name ? $emp->name : '' }}"/>
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $reimbursement->date ?? date('Y-m-d') }}" class="col-md-4"/>
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
                        <x-form.select label="Kategori Reimbursement" name="category_id" required :datas="$categories" options="- Pilih Kategori Reimbursement -" value="{{ $reimbursement->category_id ?? '' }}"/>
                        <x-form.input label="Nilai" name="value" required placeholder="Nilai" class="col-md-4" currency value="{{ $reimbursement->value ?? 0 }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Keterangan" required name="description" placeholder="Keterangan" value="{{ $reimbursement->description ?? '' }}"/>
                        <x-form.file label="File Pendukung" name="filename" value="{{ $reimbursement->filename ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection