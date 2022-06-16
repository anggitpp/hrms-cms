<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($selection) ? route('recruitments.'.$arrMenu['target'].'.store', [$id, $planId]) : route('recruitments.'.$arrMenu['target'].'.update', $selection->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($selection))
        @method('PATCH')
    @endif
    <x-form.datepicker label="Tanggal" required name="selection_date" value="{{ $selection->selection_date ?? date('Y-m-d') }}"/>
    <x-form.timepicker label="Waktu" name="selection_time" class="col-md-3" value="{{ $selection->selection_time ?? '' }}"/>
    <x-form.radio label="Hasil" name="result" :datas="$results" value="{{ $selection->result ?? '' }}" />
    <x-form.textarea label="Deskripsi" name="description" value="{{ $selection->description ?? '' }}" />
    <x-form.file label="File" name="filename" value="{{ $selection->filename ?? '' }}" />
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
