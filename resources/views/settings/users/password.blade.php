<div class="alert alert-danger" style="display:none"></div>
<form id="form-edit" method="POST"
      action="{{ route('settings.users.updatePassword', $user->id) }}
              " enctype="multipart/form-data" data-remote="true" autocomplete="off">
    @csrf
    @method('PATCH')
    <x-form.input label="Password" name="password" autocomplete="off" placeholder="*******" password />
    <x-form.input label="Confirm Password" name="confirm-password" placeholder="*******" password />
    <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
</form>