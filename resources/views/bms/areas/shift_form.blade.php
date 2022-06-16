<form id="form-edit" method="POST"
      action=" {{ empty($shift) ? route('bms.'.$arrMenu['target'].'.shift.store', $id) : route('bms.'.$arrMenu['target'].'.shift.update', $shift->id) }}" enctype="multipart/form-data">
    @csrf
    @if(!empty($shift))
        @method('PATCH')
    @endif
    <x-form.input label="Nama" required name="name" placeholder="Nama" value="{{ $shift->name ?? '' }}" />
    <x-form.input label="Kode" required name="code" placeholder="Kode" value="{{ $shift->code ?? '' }}" />
    <x-form.timepicker label="Mulai" required name="start" class="col-md-12" value="{{ $shift->start ?? '' }}" />
    <x-form.timepicker label="Selesai" required name="end" class="col-md-12" value="{{ $shift->end ?? '' }}" />
    <x-form.select label="Durasi" required name="interval_id" :datas="$masters['BKIV']" options="- Pilih Durasi -" value="{{ $shift->interval_id ?? '' }}"/>
    <x-form.radio label="Selesai Hari Ini" name="finish_today" :datas="$finishOption" value="{{ $shift->finish_today ?? '' }}"/>
    <x-form.textarea label="Keterangan" name="description" value="{{ $shift->description ?? '' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $shift->status ?? '' }}"/>
    <x-form.input label="Urutan" name="order" value="{{ $shift->order ?? $lastOrder + 1 }}" class="col-md-2" currency />
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
</form>
