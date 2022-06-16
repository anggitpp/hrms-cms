<form id="form-edit" method="POST"
      action=" {{ route('payrolls.process.approve.update', $process->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <x-form.input label="Nama" readonly name="name" placeholder="Nama" value="{{ $user->name ?? Auth::user()->name }}" />
    <x-form.datepicker label="Tanggal" class="col-md-12" name="approved_date" value="{{ $process->approved_date ?? date('Y-m-d') }}" />
    <x-form.textarea label="Catatan" name="approved_description" value="{{ $process->approved_description ?? '' }}"/>
    <x-form.radio label="Status" name="approved_status" :datas="$status" value="{{ $process->approved_status == 'p' ? 't' : $process->approved_status }}"/>
    @if($process->approved_status != 't')
        <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
    @endif
</form>
