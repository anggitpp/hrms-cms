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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($permission) ? route('staff.permissions.store') :
            (str_contains(Request::route()->getName(), 'approve') ? route('staff.permissions.approve.update', $permission->id) : route('staff.permissions.update', $permission->id)) }}">
                @csrf
                @if(!empty($permission))
                    @method('PATCH')
                @endif
                @php
                if(!empty($permission))
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
                        <x-form.input label="Nomor Pengajuan" name="number" readonly value="{{ $permission->number ?? $permissionNumber }}"/>
                        <x-form.select label="Nama Pegawai" name="employee_id" :datas="$employees" value="{{ $permission->employee_id ?? '' }}" options="- Pilih Pegawai -" event="getEmployeeDetails(this.value)" />
                        <x-form.input label="Posisi" name="position" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.datepicker label="Tanggal Pengajuan" name="date" value="{{ $permission->date ?? date('Y-m-d') }}" class="col-md-4" />
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
                        <x-form.select label="Kategori Izin" name="category_id" required :datas="$categories" options="- Pilih Kategori Izin -" value="{{ $permission->category_id ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $permission->start_date ??'' }}" class="col-md-4" />
                        <x-form.file label="File Pendukung" name="filename" value="{{ $permission->filename ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Keterangan" name="description" placeholder="Keterangan" value="{{ $permission->description ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Selesai" required name="end_date" value="{{ $permission->end_date ??'' }}" class="col-md-4" />
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
                            <x-form.datepicker label="Tanggal Approve" name="approved_date" value="{{ $permission->approved_date ?? date('Y-m-d') }}" class="col-md-4" />
                            <x-form.radio label="Status Approve" name="approved_status" :datas="$approveStatus" value="{{ $permission->approved_status == 'p' ? '' : $permission->approved_status }}"/>
                            <x-form.textarea label="Catatan" name="approved_note" value="{{ $permission->approved_note ?? '' }}"/>
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
                url: '/staff/permissions/getEmployeeDetails/' + value,
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
