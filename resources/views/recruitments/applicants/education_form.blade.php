<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($edu) ? route('recruitments.applicants.education.store', $id) : route('recruitments.applicants.education.update', $edu->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($edu))
        @method('PATCH')
    @endif
    <x-form.select label="Tingkatan" required name="level_id" :datas="$masters['SPD']" options="- Pilih Tingkatan -" value="{{ $edu->level_id ?? '' }}" />
    <x-form.input label="Nama" required name="name" placeholder="Nama" value="{{ $edu->name ?? '' }}" />
    <x-form.input label="Jurusan" name="major" placeholder="Jurusan" value="{{ $edu->major ?? '' }}" />
    <x-form.input label="Nilai" name="score" placeholder="Nilai" value="{{ $edu->score ?? '' }}" />
    <x-form.input label="Kota" name="city" placeholder="Kota" value="{{ $edu->city ?? '' }}" />
    <div class="row">
        <div class="col-md-6">
            <x-form.input label="Tahun Mulai" numeric name="start_year" placeholder="Tahun Mulai" value="{{ $edu->start_year ?? '' }}" />
        </div>
        <div class="col-md-6">
            <x-form.input label="Tahun Selesai" numeric name="end_year" placeholder="Tahun Selesai" value="{{ $edu->end_year ?? '' }}" />
        </div>
    </div>
    <x-form.input label="Essay" name="essay" placeholder="Essay" value="{{ $edu->essay ?? '' }}"/>
    <x-form.file label="File" name="filename" value="{{ $edu->filename ?? '' }}"/>
    <x-form.textarea label="Keterangan" name="description" value="{{ $edu->description ?? '' }}"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
