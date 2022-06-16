<div class="alert alert-danger" style="display:none"></div>

<form id="form-edit" method="POST" class="form-validation"
      action=" {{ empty($category) ? route('settings.masters.store') : route('settings.masters.update', $category->id) }}"
      enctype="multipart/form-data">
    @csrf
    @if(!empty($category))
        @method('PATCH')
    @endif
    <x-form.select label="Modul" required name="modul_id" value="{{ $category->modul_id ?? $_GET['filterModul'] ?? $defaultModul }}" options="- Select Modul -" :datas="$moduls" />
    <x-form.select label="Parent" name="parent_id" value="{{ $category->parent_id ?? '' }}" options="- Select Parent -" :datas="$categories" />
    <x-form.input label="Name" required name="name" placeholder="Name" value="{{ $category->name ?? '' }}"/>
    <x-form.input label="Code" required name="code" maxlength="5" nospacing placeholder="Code" value="{{ $category->code ?? '' }}"/>
    <x-form.textarea label="Description" name="description" value="{{ $category->description ?? '' }}"/>
    <x-form.input label="Order" name="order" value="{{ $category->order ?? $lastCategory }}" class="col-md-2" currency/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Save</button>
</form>
