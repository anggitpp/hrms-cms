<form id="form-edit" method="POST"
      action="{{ empty($menu) ? route('settings.menus.store') : route('settings.menus.update', $menu->id) }}">
    @csrf
    @if(!empty($menu))
        @method('PATCH')
    @endif
    <input type="hidden" id="id" value="{{ $menu->id ?? '' }}"/>
    @if(!empty($parentMenu) || !empty($menu->parent_id))
        @if(empty($menu->parent_id))
            <x-form.input label="Parent" name="parent_name" value="{{ $menu->parent_id ?? $parentMenu->name }}" readonly />
            <input type="hidden" name="parent_id" value="{{ $menu->parent_id ?? $parentMenu->id }}"/>
        @endif
    @else
        <x-form.select label="Modul" name="modul_id" value="{{ $menu->modul_id ?? $_GET['filterModul'] ?? $defaultModul }}" :datas="$moduls" options="- Select Modul -"/>
        <x-form.select label="Sub Modul" name="sub_modul_id" value="{{ $menu->sub_modul_id ?? $defaultSubModul }}" :datas="$sub_moduls" options="- Select Sub Modul -"/>
    @endif
    <x-form.input label="Name" name="name" placeholder="Name" value="{{ $menu->name ?? '' }}" />
    <x-form.input label="Target" name="target" placeholder="Target" value="{{ $menu->target ?? '' }}" />
    <x-form.input label="Controller" name="controller" placeholder="Controller" value="{{ $menu->controller ?? '' }}" />
    <x-form.input label="Parameter" name="parameter" placeholder="Parameter" value="{{ $menu->parameter ?? '' }}" />
    @if(empty($menu))
        <x-form.radio label="Access" name="access" :datas="$listAccess" value="{{ $menu->access ?? '' }}"/>
    @endif
    <x-form.textarea label="Description" name="description" value="{{ $menu->description ?? '' }}" />
    <x-form.input label="Icon" name="icon" placeholder="Icon" value="{{ $menu->icon ?? 'fa fa-users' }}" />
    <x-form.radio label="Full Screen" name="full_screen" :datas="$screen" value="{{ $menu->full_screen ?? '' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $menu->status ?? '' }}"/>
    <x-form.input label="Urutan" name="order" class="col-md-2" currency value="{{ $menu->order ?? $lastMenu }}"/>
    <input type="submit" class="btn btn-primary mb-25   " style="width: 100%" value="Save"/>
</form>

