<form id="form-edit" enctype="multipart/form-data" method="POST" action="{{ route('mobiles.activations.update', $activation->id) }}">
    @csrf
    @method('PATCH')
    @php
        list($date, $time) = explode(' ', $activation->created_at);
        $activation->date = setDate($date, 't')." ".$time;
    @endphp
    <x-form.input label="Username" name="username" readonly value="{{ $user->username }}"/>
    <x-form.input label="Nama" name="name" readonly value="{{ $user->name }}"/>
    <x-form.input label="Nama Perangkat" name="device_name" readonly value="{{ $activation->device_name }}"/>
    <x-form.input label="Waktu Request" name="date" readonly value="{{ $activation->date }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $activation->status }}"/>
    <input type="submit" class="btn btn-primary " style="width: 100%" value="Simpan"/>
</form>