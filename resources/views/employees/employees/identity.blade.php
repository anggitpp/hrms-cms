<!-- PROFILE -->
<div class="col-lg-12">
    <div class="row justify-content-center">
        <img class="img-fluid rounded" src="{{ asset( $emp->photo ? 'storage/'.$emp->photo : 'storage/uploads/images/nophoto.png') }}" height="104" width="104" style="max-width:100%;max-height:100%;" alt="User avatar"/>
    </div>
    <br>
    <div class="row justify-content-center">
        <h4>{{ $emp->name }} <span style="color: darkgray; font-size: 15px;">{{ $emp->nickname ? '('.$emp->nickname.')' : '' }} </span></h4>
    </div>
    <div class="row justify-content-center">
        <h6><i>{{ $emp->emp_number }} - {{ isset($empc->position_id) ? $masters['EJP'][$empc->position_id] : '' }}</i></h6>
    </div>
</div>
<br>
<div class="card-title">
    <h4>Identitas</h4>
    <hr>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tempat Lahir</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->birth_place }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal Lahir</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ setDate($emp->birth_date,'t') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">No. KTP</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->identity_number }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Gender</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->gender == 'f' ? 'Female' : 'Male' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Agama</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $masters['SAG'][$emp->religion_id] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Email</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->email }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Alamat Domisili</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->address }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Alamat KTP</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->identity_address }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">No. Telp</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->phone }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">No. HP</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->mobile_phone }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Status Perkawinan</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($masters[$emp->marital_id]) ? $masters['ESK'][$emp->marital_id] : '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Gol. Darah</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $emp->blood_type }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal Masuk</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ setDate($emp->birth_date) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal Keluar</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ setDate($emp->leave_date) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Status Pegawai</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $masters['ESP'][$emp->status_id] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        &nbsp;
    </div>
</div>

<!-- POSITION -->
<br>
<div class="card-title">
    <h4>Posisi</h4>
    <hr>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Posisi</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->position_id) ? $masters['EJP'][$empc->position_id] : '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tipe Pegawai</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->type_id) ? $masters['ETP'][$empc->type_id] : '' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Pangkat</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->type_id) ? $masters['EP'][$empc->rank_id] : '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Grade</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->grade_id) ? $masters['EG'][$empc->grade_id] : '' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Nomor SK</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $empc->sk_number ?? '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Lokasi Kerja</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->location_id) ? $masters['ELK'][$empc->location_id] : '' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal Mulai</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->start_date) ? setDate($empc->start_date) : '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal Berakhir</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($empc->end_date) ? setDate($empc->end_date) : '' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Penempatan</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ isset($placements[$empc->placement_id]) ? $placements[$empc->placement_id] : '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Shift</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{isset($empc->shift_id) ? $shifts[$empc->shift_id] : '' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="d-flex flex-wrap">
            <div class="col-md-4">
                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Deskripsi</p>
            </div>
            <div class="col-md-8">
                <p class="c ard-text mb-50">{{ $empc->description ?? '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        &nbsp;
    </div>
</div>

<!-- PAYROLL -->
{{--<br>--}}
{{--<div class="card-title">--}}
{{--    <h4>Payroll</h4>--}}
{{--    <hr>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Jenis Payroll</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $masters['EJPR'][$empp->payroll_id] }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Bank</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $masters['SB'][$empp->bank_id] }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Pemilik Rekening</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->account_name }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Nomor Rekening</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->account_number }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">No. NPWP</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->npwp_number }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal NPWP</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->npwp_date ? setDate($empp->npwp_date) : '' }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Nomor BPJS TK</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->bpjs_tk_number }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal BPJS TK</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="card-text mb-50">{{ $empp->bpjs_tk_date ? setDate($empp->bpjs_tk_date) : '' }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Nomor BPJS KS</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->bpjs_number }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="d-flex flex-wrap">--}}
{{--            <div class="col-md-4">--}}
{{--                <p class="card-text user-info-title font-weight-bold mb-50 mr-50">Tanggal BPJS KS</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <p class="c ard-text mb-50">{{ $empp->bpjs_date ? setDate($empp->bpjs_date) : '' }}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
