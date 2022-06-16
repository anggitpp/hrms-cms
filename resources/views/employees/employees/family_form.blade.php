<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($family) ? route('employees.'.$arrMenu['target'].'.family.store', $id) : route('employees.'.$arrMenu['target'].'.family.update', $family->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($family))
        @method('PATCH')
    @endif
    <x-form.input label="Nama" required name="name" placeholder="Nama" value="{{ $family->name ?? '' }}" />
    <x-form.select label="Hubungan" required name="relation_id" :datas="$masters['EHK']" options="- Pilih Hubungan -" value="{{ $family->relation_id ?? '' }}" />
    <x-form.input label="No. KTP" name="identity_number" placeholder="No. KTP" value="{{ $family->identity_number ?? '' }}" />
    <x-form.radio label="Gender" name="gender" :datas="$gender" value="{{ $family->gender ?? '' }}" />
    <x-form.input label="Tempat Lahir" name="birth_place" placeholder="Tempat Lahir" value="{{ $family->birth_place ?? '' }}"/>
    <x-form.datepicker label="Tanggal Lahir" name="birth_date" value="{{ $family->birth_date ?? '' }}" class="col-md-6" />
    <x-form.file label="Foto" name="filename" value="{{ $family->filename ?? '' }}"/>
    <x-form.input label="Keterangan" name="description" placeholder="Keterangan" value="{{ $family->description ?? '' }}"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
