<form id="form-edit" method="POST" class="form-validation"
      action=" {{ empty($modul) ? route('settings.moduls.store') : route('settings.moduls.update', $modul->id) }}"
      enctype="multipart/form-data">
    @csrf
    @if(!empty($modul))
        @method('PATCH')
    @endif
    <input type="hidden" id="id" value="{{ $modul->id ?? '' }}"/>
    <x-form.input label="Name" required name="name" placeholder="Name" value="{{ $modul->name ?? '' }}"/>
    <x-form.input label="Target" required name="target" placeholder="Target" value="{{ $modul->target ?? '' }}"/>
    <x-form.textarea label="Description" name="description" value="{{ $modul->description ?? '' }}"/>
    <x-form.input label="Icon" name="icon" value="{{ $modul->icon ?? 'fa fa-folder' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $modul->status ?? '' }}"/>
    <x-form.input label="Order" name="order" value="{{ $modul->order ?? $lastModul }}" class="col-md-2" currency/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Save</button>
</form>
