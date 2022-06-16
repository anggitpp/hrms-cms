<form id="form-edit" method="POST"
      action=" {{ route('employees.terminations.approve.update', $termination->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <x-form.input label="Nama" readonly name="name" placeholder="Nama" value="{{ $user->name ?? Auth::user()->name }}" />
    <x-form.datepicker label="Tanggal" class="col-md-12" name="approve_date" value="{{ $termination->approve_date ?? date('Y-m-d') }}" />
    <x-form.textarea label="Catatan" name="approve_note" value="{{ $termination->approve_note ?? '' }}"/>
    <x-form.radio label="Status" name="approve_status" :datas="$status" value="{{ $termination->approve_status ?? '' }}"/>
    @if($termination->approve_status != 't')
        <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
    @endif
</form>
