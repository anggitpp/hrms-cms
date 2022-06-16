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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($overtime) ? route('staff.overtimes.store') :
            (str_contains(Request::route()->getName(), 'approve') ? route('staff.overtimes.approve.update', $overtime->id) : route('staff.overtimes.update', $overtime->id)) }}">
                @csrf
                @if(!empty($overtime))
                    @method('PATCH')
                @endif
                @php
                if(!empty($overtime))
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
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $overtime->number ?? $overtimeNumber }}"/>
                        <x-form.select label="Nama Pegawai" name="employee_id" :datas="$employees" value="{{ $overtime->employee_id ?? '' }}" options="- Pilih Pegawai -" event="getEmployeeDetails(this.value);" />
                        <x-form.input label="Posisi" name="position" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $overtime->date ?? date('Y-m-d') }}" class="col-md-4" />
                        <x-form.input label="Pangkat" name="rank" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Lembur</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $overtime->start_date ??'' }}" class="col-md-4" />
                        <x-form.timepicker label="Jam Mulai" required name="start_time" value="{{ $overtime->start_time ?? '' }}"/>
                        <x-form.file label="File Pendukung" name="filename" value="{{ $overtime->filename ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Keterangan" required name="description" placeholder="Keterangan" value="{{ $overtime->description ?? '' }}"/>
                        <x-form.timepicker label="Jam Selesai" required name="end_time" value="{{ $overtime->end_time ?? '' }}"/>
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
                            <x-form.datepicker label="Tanggal Approve" name="approved_date" value="{{ $overtime->approved_date ?? date('Y-m-d') }}" class="col-md-4" />
                            <x-form.radio label="Status Approve" name="approved_status" :datas="$approveStatus" value="{{ $overtime->approved_status == 'p' ? '' : $overtime->approved_status }}"/>
                            <x-form.textarea label="Catatan" name="approved_note" value="{{ $overtime->approved_note ?? '' }}"/>
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
                url: '/staff/overtimes/getEmployeeDetails/' + value,
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
