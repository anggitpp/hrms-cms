<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($contract) ? route('employees.'.$arrMenu['target'].'.contract.store', $id) : route('employees.'.$arrMenu['target'].'.contract.update', $contract->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($contract))
        @method('PATCH')
    @endif
    <div class="row">
        <div class="col-md-6">
            <x-form.select label="Posisi" required name="position_id" :datas="$masters['EJP']" options="- Pilih Posisi -" value="{{ $contract->position_id ?? '' }}" />
            <x-form.select label="Pangkat" required name="rank_id" event="getSub(this.value, 'grade_id');" :datas="$masters['EP']" options="- Pilih Pangkat -" value="{{ $contract->rank_id ?? '' }}" />
            <x-form.input label="Nomor SK" name="sk_number" placeholder="Nomor SK" value="{{ $contract->sk_number ?? '' }}"/>
            <x-form.datepicker label="Tgl Mulai" required name="start_date" value="{{ $contract->start_date ?? '' }}" class="col-md-4" />
            <x-form.select label="Penempatan" name="placement_id" :datas="$masters['EDP']" options="- Pilih Penempatan -" value="{{ $contract->placement_id ?? '' }}" />
            <x-form.file label="File" name="filename" value="{{ $contract->filename ?? '' }}" />
            <x-form.radio label="Status" name="status" :datas="$status" value="{{ $contract->status ?? '' }}" />
        </div>
        <div class="col-md-6">
            <x-form.select label="Tipe Pegawai" required name="type_id" :datas="$masters['ETP']" options="- Pilih Tipe Pegawai -" value="{{ $contract->type_id ?? '' }}" />
            <x-form.select label="Grade" name="grade_id" :datas="$masters['EG']" options="- Pilih Grade -" value="{{ $contract->grade_id ?? '' }}" />
            <x-form.select label="Lokasi Kerja" required name="location_id" :datas="$masters['ELK']" options="- Pilih Lokasi Kerja -" value="{{ $contract->location_id ?? '' }}" />
            <x-form.datepicker label="Tgl Selesai" name="end_date" value="{{ $contract->end_date ?? '' }}" class="col-md-4" />
            <x-form.select label="Shift" name="shift_id" :datas="$shifts" options="- Pilih Shift -" value="{{ $contract->shift_id ?? '' }}" />
            <x-form.input label="Deskripsi" name="description" placeholder="Deskripsi" value="{{ $contract->description ?? '' }}"/>
        </div>
    </div>
    <br clear="all"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
