<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($type) ? route('payrolls.types.store') : route('payrolls.types.update', $type->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($type))
        @method('PATCH')
    @endif
    <x-form.input label="Kode" name="code" value="{{ $type->code ?? '' }}" required />
    <x-form.input label="Nama" name="name" value="{{ $type->name ?? '' }}" required />
    <x-form.textarea label="Keterangan" name="description" value="{{ $type->description ?? '' }}" />
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $type->status ?? '' }}"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
