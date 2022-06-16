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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($leave) ? route('ess.leaves.store') : route('ess.leaves.update', $leave->id) }}">
                @csrf
                @if(!empty($leave))
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
                <input type="hidden" id="employee_id" name="employee_id" value="{{ $leave->employee_id ?? Auth::user()->employee_id }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $leave->number ?? $leaveNumber }}"/>
                        <x-form.input label="Nama Pegawai" name="name" readonly value="{{ $emp->name ? $emp->name : '' }}"/>
                        <x-form.input label="Posisi" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $leave->date ?? date('Y-m-d') }}" class="col-md-4" onchange="getLeaveDetail();" />
                        <x-form.input label="NIK" name="nik" readonly value="{{ $emp->emp_number ? $emp->emp_number : '' }}"/>
                        <x-form.input label="Pangkat" name="rank_id" readonly value="{{ $rank ?? '' }}"/>
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
                    url: '/ess/leaves/getLeaveDetails/' + paramList + '?startDate=' + start_date + '&endDate=' + end_date + '&mode=' + mode + '&id=' + id,
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
    </script>
@endsection
