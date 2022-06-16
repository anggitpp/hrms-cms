<form id="form-edit" method="POST" class="form-validation"
      action="{{ empty($contact) ? route('employees.'.$arrMenu['target'].'.contact.store', $id) : route('employees.'.$arrMenu['target'].'.contact.update', $contact->id) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    @if(!empty($contact))
        @method('PATCH')
    @endif
    <x-form.input label="Nama" required name="name" placeholder="Nama" value="{{ $contact->name ?? '' }}" />
    <x-form.select label="Hubungan" required name="relation_id" :datas="$masters['EHK']" options="- Pilih Hubungan -" value="{{ $contact->relation_id ?? '' }}" />
    <x-form.input label="No. HP" required name="phone_number" placeholder="No. HP" value="{{ $contact->phone_number ?? '' }}" />
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Submit</button>
</form>
