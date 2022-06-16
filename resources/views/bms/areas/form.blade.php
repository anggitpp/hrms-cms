<form id="form-edit" method="POST"
      action=" {{ empty($area) ? route('bms.'.$arrMenu['target'].'.area.store', $id) : route('bms.'.$arrMenu['target'].'.area.update', $area->id) }}" enctype="multipart/form-data">
    @csrf
    @if(!empty($area))
        @method('PATCH')
    @endif
    <x-form.input label="Nama" required name="name" placeholder="Nama" value="{{ $area->name ?? '' }}" />
    <x-form.select label="PIC" name="employee_id" :datas="$employees" options="- Pilih PIC -" value="{{ $area->employee_id ?? '' }}"/>
    <x-form.textarea label="Keterangan" name="description" value="{{ $area->description ?? '' }}"/>
    <x-form.radio label="Shift" name="shift" :datas="$shiftOption" value="{{ $area->finish_today ?? '' }}"/>
    <x-form.input label="Kode" name="code" placeholder="Kode" readonly value="{{ $area->code ?? $lastCode }}" />
    <x-form.input label="Urutan" name="order" value="{{ $area->order ?? $lastOrder + 1 }}" class="col-md-2" numeric />
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $area->status ?? '' }}"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
