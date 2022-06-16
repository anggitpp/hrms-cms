<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($shift) ? route('attendances.shifts.store') : route('attendances.shifts.update', $shift->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($shift))
        @method('PATCH')
    @endif
    <x-form.input label="Nama" name="name" value="{{ $shift->name ?? '' }}" required />
    <x-form.input label="Kode" name="code" value="{{ $shift->code ?? '' }}" required />
    <div class="row">
        <div class="col-md-6">
           <x-form.timepicker label="Mulai" name="start" class="col-md-12" value="{{ $shift->start ?? '' }}" required/>
        </div>
        <div class="col-md-6">
            <x-form.timepicker label="Selesai" name="end" class="col-md-12" value="{{ $shift->end ?? '' }}" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <x-form.timepicker label="Istirahat Mulai" name="break_start" class="col-md-12" value="{{ $shift->break_start ?? '' }}"/>
        </div>
        <div class="col-md-6">
            <x-form.timepicker label="Istirahat Selesai" name="break_end" class="col-md-12" value="{{ $shift->break_end ?? '' }}"/>
        </div>
    </div>
    <x-form.input label="Toleransi (Menit)" name="tolerance" class="col-md-3" value="{{ $shift->tolerance ?? '' }}" maxlength="2"/>
    <x-form.radio label="Shift Malam" name="night_shift" :datas="$yesorno" value="{{ $shift->night_shift ?? '' }}" />
    <x-form.textarea label="Keterangan" name="description" value="{{ $shift->description ?? '' }}" />
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $shift->status ?? '' }}" />
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
