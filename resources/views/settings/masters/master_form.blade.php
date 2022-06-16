<div class="alert alert-danger" style="display:none"></div>

<form id="form-edit" method="POST" class="form-validation"
      action=" {{ empty($master) ? route('settings.masters.master.store', $code) : route('settings.masters.master.update', $master->id) }}"
      enctype="multipart/form-data">
    @csrf
    @if(!empty($master))
        @method('PATCH')
    @endif
    @if(isset($parents))
        <x-form.select label="Parent" required name="parent_id" value="{{ $master->parent_id ?? $_GET['filterParent'] ?? '' }}" :datas="$parents" />
    @endif
    <x-form.input label="Name" required name="name" placeholder="Name" value="{{ $master->name ?? '' }}"/>
    <x-form.input label="Code" required name="code" maxlength="5" nospacing placeholder="Code" value="{{ $master->code ?? $lastCode }}"/>
    <x-form.textarea label="Description" name="description" value="{{ $master->description ?? '' }}"/>
    <x-form.input label="Parameter" name="parameter" value="{{ $category->parameter ?? '' }}"/>
    <x-form.input label="Additional Parameter" name="additional_parameter" value="{{ $category->additional_parameter ?? '' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $master->status ?? '' }}"/>
    <x-form.input label="Order" name="order" value="{{ $master->order ?? $lastMaster }}" class="col-md-2" currency/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Save</button>
</form>
