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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($reimbursement) ? route('staff.reimbursements.store') :
            (str_contains(Request::route()->getName(), 'approve') ? route('staff.reimbursements.approve.update', $reimbursement->id) : route('staff.reimbursements.update', $reimbursement->id)) }}">
                @csrf
                @if(!empty($reimbursement))
                    @method('PATCH')
                @endif
                @php
                if(!empty($reimbursement))
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
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $reimbursement->number ?? $reimbursementNumber }}"/>
                        <x-form.select label="Nama Pegawai" name="employee_id" :datas="$employees" value="{{ $reimbursement->employee_id ?? '' }}" options="- Pilih Pegawai -" event="getEmployeeDetails(this.value)" />
                        <x-form.input label="Posisi" name="position" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $reimbursement->date ?? date('Y-m-d') }}" class="col-md-4" />
                        <x-form.input label="Pangkat" name="rank" readonly value="{{ $rank ?? '' }}"/>
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
                <br>
                @if(str_contains(Request::route()->getName(), 'approve'))
                    <div class="card-title">
                        <div class="d-flex justify-content-between">
                            <h5>Data Approval</h5>
                            <span style="font-size: 13px; color: #7367f0"><i>NOTE : SAAT MELAKUKAN APPROVAL, DATA DIATAS TIDAK AKAN BERUBAH WALAU DI EDIT</i></span>
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.datepicker label="Tanggal Approve" name="approved_date" value="{{ $reimbursement->approved_date ?? date('Y-m-d') }}" class="col-md-4" />
                            <x-form.radio label="Status Approve" name="approved_status" :datas="$approveStatus" value="{{ $reimbursement->approved_status == 'p' ? '' : $reimbursement->approved_status }}"/>
                            <x-form.textarea label="Catatan" name="approved_note" value="{{ $reimbursement->approved_note ?? '' }}"/>
                        </div>
                    </div>
                    <div>
                        <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                            Simpan
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        route = '{{ Request::route()->getName() }}';
        if(route.includes('approve')) {
            window.scrollTo(0, document.body.scrollHeight);
        }
        //GET EMPLOYEE DETAIL DATA
        function getEmployeeDetails(value){
            $.ajax({
                url: '/staff/reimbursements/getEmployeeDetails/' + value,
                method: "get",
                dataType: "json",
                success: function (data) {
                    $('#rank').val(data['rankName']);
                    $('#position').val(data['positionName']);
                },
            });
        }
    </script>
@endsection
