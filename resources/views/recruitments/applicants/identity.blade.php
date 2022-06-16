<!-- PROFILE -->
<div class="col-lg-12">
    <div class="row justify-content-center">
        <img class="img-fluid rounded" src="{{ asset( $appl->photo ? 'storage/'.$appl->photo : 'storage/nophoto.png') }}" height="104" width="104" style="max-width:100%;max-height:100%;" alt="User avatar"/>
    </div>
    <br>
    <div class="row justify-content-center">
        <h4>{{ $appl->name }} <span style="color: darkgray; font-size: 15px;">({{ $appl->nickname }})</span></h4>
    </div>
    <div class="row justify-content-center">
        <h6><i>{{ $appl->applicant_number }} - {{ setDate($appl->input_date, 't') }}</i></h6>
    </div>
</div>
<br>
<div class="card-title">
    <h4>Identitas</h4>
    <hr>
</div>
<div class="row">
    <div class="col-md-6">
        <x-form.span label="Rencana" value="{{ $plan->title }}"/>
        <x-form.span label="Tempat Lahir" value="{{ $appl->birth_place }}"/>
        <x-form.span label="No. Identitas" value="{{ $appl->identity_number }}"/>
        <x-form.span label="Agama" value="{{ $appl->religion_id ? $masters['SAG'][$appl->religion_id] : '' }}"/>
    </div>
    <div class="col-md-6">
        <x-form.span label="Posisi" value="{{ $plan->position }}"/>
        <x-form.span label="Tanggal Lahir" value="{{ setDate($appl->birth_date,'t') }}"/>
        <x-form.span label="Jenis Kelamin" value="{{ $appl->gender == 'f' ? 'Female' : 'Male' }}"/>
        <x-form.span label="Email" value="{{ $appl->email }}"/>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <x-form.span label="Alamat Domisili" value="{{ $appl->address }}"/>
    </div>
    <div class="col-md-6">
        <x-form.span label="Alamat KTP" value="{{ $appl->identity_address }}"/>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <x-form.span label="No. Telp" value="{{ $appl->phone }}"/>
        <x-form.span label="Status Kawin" value="{{ $appl->marital_id ? $masters['ESK'][$appl->marital_id] : '' }}"/>
        <x-form.span label="Berat Badan" value="{{ $appl->weight }}"/>
        <x-form.span label="File KTP" file value="{!! $appl->identity_file !!}" />
    </div>
    <div class="col-md-6">
        <x-form.span label="No. HP" value="{{ $appl->mobile_phone }}"/>
        <x-form.span label="Gol. Darah" value="{{ $appl->blood_type }}"/>
        <x-form.span label="Tinggi Badan" value="{{ $appl->height }}"/>
    </div>
</div>
