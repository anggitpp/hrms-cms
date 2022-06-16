<div class="alert alert-danger" style="display:none"></div>
<form id="form-edit" method="POST"
      action="{{ empty($user) ? route('settings.users.store') : route('settings.users.update', $user->id) }}
          " enctype="multipart/form-data" data-remote="true" autocomplete="off">
    @csrf
    @if(!empty($user))
        @method('PATCH')
    @endif
    <input type="hidden" id="id" value="{{ $user->id ?? '' }}"/>
    <x-form.input label="Username" nospacing name="username" placeholder="Username" value="{{ $user->username ?? '' }}" />
    <x-form.select label="Pegawai" name="employee_id" :datas="$employees" options="- Pilih Pegawai -" value="{{ $user->employee_id ?? '' }}"/>
    <x-form.input label="Name" name="name" id="name" placeholder="Name" value="{{ $user->name ?? '' }}" />
    <x-form.input label="Phone Number" name="phone_number" placeholder="Phone Number" numeric value="{{ $user->phone_number ?? '' }}" />
    <x-form.select label="Group" name="group_id" options="- Select Group -" :datas="$groups" value="{{ $user->group_id ?? '' }}" />
    @if(empty($user))
        <x-form.input label="Password" name="password" autocomplete="off" placeholder="*******" password />
        <x-form.input label="Confirm Password" name="confirm-password" placeholder="*******" password />
    @endif
    <x-form.textarea label="Description" name="description" value="{{ $user->description ?? '' }}"/>
    <x-form.file label="Picture" name="picture" value="{{ $user->picture ?? '' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $user->status ?? '' }}"/>
    <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
</form>
<br/>
<script>
    $('#employee_id').change(function (){  //GET USERS DATA
        $.ajax({
            url: '/settings/users/getEmployeeDetail/' + this.value,
            method: "get",
            dataType: "json",
            success: function (data) {
                $('#name').val(data['name']);
                $('#phone_number').val(data['phone_number'] ?? '');
            },
        });
    });
</script>
