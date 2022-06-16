<form id="form-edit" method="POST"
      action="{{ empty($accesses) ? route('settings.menus.function.store', $menu->id) : route('settings.menus.function.update', $accesses->id) }}">
    @csrf
    @if(!empty($accesses))
        @method('PATCH')
    @endif
    <x-form.input label="Name" name="name" placeholder="Name" value="{{ $accesses->name ?? '' }}" />
    <x-form.select label="Method" name="methods" value="{{ $accesses->method ?? '' }}" :datas="$listMethod"/>
    <x-form.input label="Param" name="param" placeholder="Parameter" value="{{ $accesses->param ?? '' }}" />
    <input type="submit" class="btn btn-primary mb-25   " style="width: 100%" value="Save"/>
</form>
