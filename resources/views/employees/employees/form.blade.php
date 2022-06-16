@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Data Pegawai</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($emp) ? route('employees.'.$arrMenu['target'].'.store') : route('employees.'.$arrMenu['target'].'.update', $emp->id) }}">
                @csrf
                @if(!empty($emp))
                    @method('PATCH')
                @endif
                <ul class="nav nav-tabs" role="tablist" style="border-bottom: 1px solid; color: #DFDFDF;">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="true">Identitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" aria-controls="contract" role="tab" aria-selected="true">Posisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payroll-tab" data-toggle="tab" href="#payroll" aria-controls="payroll" role="tab" aria-selected="true">Payroll</a>
                    </li>
                </ul>
                <!-- PROFILE -->
                <div class="tab-content">
                    <div class="tab-pane active" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input label="Nama" name="name" required placeholder="Nama" value="{{ $emp->name ?? '' }}"/>
                                <x-form.input label="Tempat Lahir" required name="birth_place" placeholder="Tempat Lahir" value="{{ $emp->birth_place ?? '' }}"/>
                                <x-form.select label="Agama" name="religion_id" required :datas="$masters['SAG']" options="- Pilih Agama -" value="{{ $emp->religion_id ?? '' }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input label="Alias" name="nickname" placeholder="Alias" value="{{ $emp->nickname ?? '' }}"/>
                                <x-form.datepicker label="Tanggal Lahir" required name="birth_date" value="{{ $emp->birth_date ?? '' }}" class="col-md-6" />
                                <x-form.radio label="Jenis Kelamin" name="gender" :datas="$gender" value="{{ $emp->gender ?? '' }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input label="NIK" readonly name="emp_number" placeholder="NIK" value="{{ $emp->emp_number ?? $empNumber }}"/>
                                <x-form.input label="Nomor KTP" required numeric maxlength="16" name="identity_number" placeholder="Nomor KTP" value="{{ $emp->identity_number ?? '' }}"/>
                                <x-form.input label="Email" name="email" placeholder="Email" value="{{ $emp->email ?? '' }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <x-form.textarea label="Alamat Domisili" name="address" value="{{ $emp->address ?? '' }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.textarea label="Alamat KTP" name="identity_address" value="{{ $emp->identity_address ?? '' }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.select label="Status Perkawinan" name="marital_id" :datas="$masters['ESK']" options="- Pilih Status Perkawinan -" value="{{ $emp->marital_id ?? '' }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input label="Nomor Telp" name="phone" placeholder="Nomor Telp" value="{{ $emp->phone ?? '' }}"/>
                                <x-form.select label="Status Pegawai" required name="status_id" :datas="$masters['ESP']" options="- Pilih Status Pegawai -" value="{{ $emp->status_id ?? '' }}" />
                                <x-form.file label="Foto" imageOnly name="photo" value="{{ $emp->photo ?? '' }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input label="Nomor Handphone" name="mobile_phone" placeholder="Nomor Handphone" value="{{ $emp->mobile_phone ?? '' }}"/>
                                <x-form.datepicker label="Tanggal Masuk" required name="join_date" value="{{ $emp->join_date ?? '' }}" class="col-md-6" />
                                <x-form.file label="File KTP" imageOnly name="identity_file" value="{{ $emp->identity_file ?? '' }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.select label="Golongan Darah" name="blood_type" :datas="$bloodTypes" options="- Pilih Golongan Darah -" value="{{ $emp->blood_type ?? '' }}" />
                                <x-form.datepicker label="Tanggal Keluar" name="leave_date" value="{{ $emp->leave_date ?? '' }}" class="col-md-6" />
                            </div>
                        </div>
                    </div>
                    <!-- CONTRACT -->
                    <div class="tab-pane" id="contract" aria-labelledby="contract-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.select label="Posisi" required name="position_id" :datas="$masters['EJP']" options="- Pilih Posisi -" value="{{ $empc->position_id ?? '' }}" />
                                <x-form.select label="Pangkat" required name="rank_id" event="getSub(this.value, 'grade_id');" :datas="$masters['EP']" options="- Pilih Pangkat -" value="{{ $empc->rank_id ?? '' }}" />
                                <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $empc->start_date ?? '' }}" class="col-md-4" />
                                <x-form.input label="Nomor SK" name="sk_number" placeholder="Nomor SK" value="{{ $empc->sk_number ?? '' }}"/>
                                <x-form.input label="Atasan" name="leader_id" value="{{ $placementData->leaderName ?? '' }}" readonly/>
                                <x-form.select label="Lokasi Kerja" required name="location_id" event="getSub(this.value, 'area_id');" :datas="$masters['ELK']" options="- Pilih Lokasi Kerja -" value="{{ $empc->location_id ?? '' }}" />
                                <x-form.select label="Shift Kerja" name="shift_id" :datas="$shifts" options="- Pilih Shift Kerja -" value="{{ $empc->shift_id ?? '' }}" />
                                <x-form.input label="Keterangan" name="description" placeholder="Keterangan" value="{{ $empc->description ?? '' }}"/>
                            </div>
                            <div class="col-md-6">
                                <x-form.select label="Tipe Pegawai" required name="type_id" :datas="$masters['ETP']" options="- Pilih Tipe Pegawai -" value="{{ $empc->type_id ?? '' }}" />
                                <x-form.select label="Grade" name="grade_id" :datas="$masters['EG']" options="- Pilih Grade -" value="{{ $empc->grade_id ?? '' }}" />
                                <x-form.datepicker label="Tanggal Selesai" name="end_date" value="{{ $empc->end_date ?? '' }}" class="col-md-4" />
                                <x-form.select label="Divisi" required name="placement_id" :datas="$placements" options="- Pilih Divisi -" value="{{ $empc->placement_id ?? '' }}" event="getPlacementDetail(this.value);" />
                                <x-form.input label="Admin" name="administration_id" value="{{ $placementData->adminName ?? '' }}" readonly/>
                                <x-form.select label="Area Kerja" name="area_id" :datas="$masters['EAK']" options="- Pilih Area Kerja -" value="{{ $empc->area_id ?? '' }}" />
                                <x-form.file label="File Pendukung" name="filename" value="{{ $empc->filename ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <!-- PAYROLL -->
                    <div class="tab-pane" id="payroll" aria-labelledby="payroll-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.select label="Jenis Payroll" required name="payroll_id" :datas="$payrolls" options="- Pilih Jenis Payroll -" value="{{ $empp->payroll_id ?? '' }}" />
                                <x-form.select label="Bank" required name="bank_id" :datas="$masters['SB']" options="- Pilih Bank -" value="{{ $empp->bank_id ?? '' }}" />
                                <x-form.input label="Nama Pemilik Rekening" name="account_name" placeholder="Nama Pemilik Rekening" value="{{ $empp->account_name ?? '' }}"/>
                                <x-form.input label="Nomor Rekening" name="account_number" placeholder="Nomor Rekening" value="{{ $empp->account_number ?? '' }}"/>
                                <x-form.input label="No. BPJS TK" name="bpjs_tk_number" placeholder="No. BPJS TK" value="{{ $empp->bpjs_tk_number ?? '' }}"/>
                                <x-form.datepicker label="Tanggal BPJS TK" name="bpjs_tk_date" value="{{ $empp->bpjs_tk_date ?? '' }}" class="col-md-4" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input label="No. NPWP" name="npwp_number" placeholder="No. NPWP" value="{{ $empp->npwp_number ?? '' }}"/>
                                <x-form.datepicker label="Tanggal NPWP" name="npwp_date" value="{{ $empp->npwp_date ?? '' }}" class="col-md-4" />
                                <x-form.input label="No. BPJS KS" name="bpjs_number" placeholder="No. BPJS KS" value="{{ $empp->bpjs_number ?? '' }}"/>
                                <x-form.datepicker label="Tanggal BPJS KS" name="bpjs_date" value="{{ $empp->bpjs_date ?? '' }}" class="col-md-4" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function getPlacementDetail(value) {
            $.ajax({
                url: '/employees/actives/getPlacementDetail/' + value,
                method: "get",
                dataType: "json",
                success: function (data) {
                    $('#leader_id').val(data['leaderName']);
                    $('#administration_id').val(data['adminName']);
                },
            });
        }
    </script>
@endsection
