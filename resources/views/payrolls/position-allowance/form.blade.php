<form id="form-edit" method="POST" class="form-validation"
      action="{{ route('payrolls.position-allowance.update', $id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    <x-form.input label="Nama" name="name" value="{{ $allowance->name ?? '' }}" readonly required />
    <x-form.input label="Nilai" name="value" currency value="{{ $allowance->value ?? 0 }}" required />
    <x-form.textarea label="Keterangan" name="description" value="{{ $allowance->description ?? '' }}" />
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
