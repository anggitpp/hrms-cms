<form id="form-edit" method="POST"
      action=" {{ empty($submoduls) ? route('settings.submoduls.store') : route('settings.submoduls.update', $submoduls->id) }}
          " enctype="multipart/form-data">
    @csrf
    @if(!empty($submoduls))
        @method('PATCH')
    @endif
    <input type="hidden" id="id" value="{{ $submoduls->id ?? '' }}"/>
    <x-form.select label="Modul" name="modul_id" value="{{ $submoduls->modul_id ?? $_GET['filterModul'] ?? $defaultModul }}" options="- Select Modul -" :datas="$moduls" />
    <x-form.input label="Name" name="name" placeholder="Name" value="{{ $submoduls->name ?? '' }}" />
    <x-form.textarea label="Description" name="description" value="{{ $submoduls->description ?? '' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $submoduls->status ?? '' }}"/>
    <x-form.input label="Order" name="order" value="{{ $submoduls->order ?? $lastSubModul }}" class="col-md-2" currency />
    <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
</form>
