<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($work) ? route('recruitments.applicants.work.store', $id) : route('recruitments.applicants.work.update', $work->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($work))
        @method('PATCH')
    @endif
    <x-form.input label="Perusahaan" required name="company" placeholder="Perusahaan" value="{{ $work->company ?? '' }}" />
    <x-form.input label="Posisi" required name="position" placeholder="Posisi" value="{{ $work->position ?? '' }}" />
    <x-form.datepicker label="Tgl Mulai" class="col-md-12" required name="start_date" value="{{ $work->start_date ?? '' }}" />
    <x-form.datepicker label="Tgl Selesai" class="col-md-12" name="end_date" value="{{ $work->end_date ?? '' }}" />
    <x-form.input label="Kota" name="city" placeholder="Kota" value="{{ $work->city ?? '' }}" />
    <x-form.textarea label="Uraian Tugas" name="job_desc" value="{{ $work->job_desc ?? '' }}"/>
    <x-form.file label="File" name="filename" value="{{ $work->filename ?? '' }}"/>
    <x-form.textarea label="Keterangan" name="description" value="{{ $work->description ?? '' }}"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
