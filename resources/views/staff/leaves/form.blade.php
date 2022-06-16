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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($leave) ? route('staff.leaves.store') :
            (str_contains(Request::route()->getName(), 'approve') ? route('staff.leaves.approve.update', $leave->id) : route('staff.leaves.update', $leave->id)) }}">
                @csrf
                @if(!empty($leave))
                    @method('PATCH')
                @endif
                @php
                if(!empty($leave))
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
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $leave->number ?? $leaveNumber }}"/>
                        <x-form.select label="Nama Pegawai" name="employee_id" :datas="$employees" value="{{ $leave->employee_id ?? '' }}" options="- Pilih Pegawai -" event="getEmployeeDetails(this.value);getLeaveDetail();" />
                        <x-form.input label="Posisi" name="position" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $leave->date ?? date('Y-m-d') }}" class="col-md-4" onchange="getLeaveDetail();" />
                        <x-form.input label="Pangkat" name="rank" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Data Cuti</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Tipe Cuti" name="type_id" required :datas="$leaves" options="- Pilih Tipe Cuti -" value="{{ $leave->type_id ?? '' }}"
                                       event="getLeaveDetail();" />
                        <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $leave->start_date ??'' }}" class="col-md-4" onchange="getLeaveDetail();" />
                        <x-form.input label="Jumlah Hari" required class="col-md-2 text-right" name="amount" readonly value="{{ $leave->amount ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Jatah Cuti" required class="col-md-2 text-right" name="quota" readonly value="{{ $leave->quota ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Selesai" required name="end_date" onchange="getLeaveDetail();" value="{{ $leave->end_date ??'' }}" class="col-md-4" />
                        <x-form.input label="Sisa Cuti" required class="col-md-2 text-right" name="remaining" readonly value="{{ $leave->remaining ?? '' }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.file label="File Pendukung" name="filename" value="{{ $leave->filename ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Keterangan" name="description" placeholder="Keterangan" value="{{ $leave->description ?? '' }}"/>
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
                            <x-form.datepicker label="Tanggal Approve" name="approved_date" value="{{ $leave->approved_date ?? date('Y-m-d') }}" class="col-md-4" onchange="getLeaveDetail();" />
                            <x-form.radio label="Status Approve" name="approved_status" :datas="$approveStatus" value="{{ $leave->approved_status == 'p' ? '' : $leave->approved_status }}"/>
                            <x-form.textarea label="Catatan" name="approved_note" value="{{ $leave->approved_note ?? '' }}"/>
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
        mode = route.includes('edit') ? 'edit' : 'add';
        if(route.includes('approve')) {
            window.scrollTo(0, document.body.scrollHeight);
        }
        //GET LEAVE DETAIL DATA
        function getLeaveDetail(){
            employee_id = $('#employee_id').val();
            type_id = $('#type_id').val();
            start_date = $('#start_date').val();
            end_date = $('#end_date').val();
            if(mode == 'edit'){
                id = '{{ Route::current()->parameters()['id'] ?? '' }}';
            }else{
                id = '';
            }
            if(employee_id != '' && type_id != '') {
                paramList = [type_id, employee_id ].join('/');
                $.ajax({
                    url: '/staff/leaves/getLeaveDetails/' + paramList + '?startDate=' + start_date + '&endDate=' + end_date + '&mode=' + mode + '&id=' + id,
                    method: "get",
                    dataType: "json",
                    success: function (data) {
                        if (data['remaining'] > 0) {
                            $('#quota').val(data['quota']);
                            $('#amount').val(data['amount']);
                            $('#remaining').val(data['remaining']);
                        } else if(data['remaining'] <= 0) {
                            alert('Jumlah hari yang melebihi jatah cuti atau anda tidak bisa mengambil cuti tersebut');
                            $('#end_date').val('');
                            $('#quota').val('');
                            $('#amount').val('');
                            $('#remaining').val('');
                        } else {
                            $('#end_date').val('');
                            $('#quota').val('');
                            $('#amount').val('');
                            $('#remaining').val('');
                        }
                    },
                });
            }
        }

        //GET EMPLOYEE DETAIL DATA
        function getEmployeeDetails(value){
            $.ajax({
                url: '/staff/leaves/getEmployeeDetails/' + value,
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
