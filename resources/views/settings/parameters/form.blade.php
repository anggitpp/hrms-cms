<form id="form-edit" method="POST" class="form-validation"
      action=" {{ empty($param) ? route('settings.parameters.store') : route('settings.parameters.update', $param->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($param))
        @method('PATCH')
    @endif
    <x-form.input label="Code" required name="code" placeholder="Code" value="{{ $param->code ?? '' }}"/>
    <x-form.input label="Name" required name="name" placeholder="Name" value="{{ $param->name ?? '' }}"/>
    <x-form.textarea label="Value" required name="value" value="{{ $param->value ?? '' }}"/>
    <x-form.textarea label="Description" name="description" value="{{ $param->description ?? '' }}"/>
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Save</button>
</form>
