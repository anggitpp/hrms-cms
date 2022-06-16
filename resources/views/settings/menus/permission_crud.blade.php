<form id="form-edit" method="POST"
      action="{{ route('settings.menus.permission.storeCRUD', $menu->id) }}">
    @csrf
    <x-form.input label="Name" name="name" placeholder="Name" value="{{ $accesses->name ?? '' }}" />
    <x-form.input label="Param" name="param" placeholder="Parameter" value="{{ $accesses->param ?? '' }}" />
    <input type="submit" class="btn btn-primary mb-25   " style="width: 100%" value="Save"/>
</form>
