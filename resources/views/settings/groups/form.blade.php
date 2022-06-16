<form id="form-edit" method="POST"
      action=" {{ empty($group) ? route('settings.groups.store') : route('settings.groups.update', $group->id) }}
          " enctype="multipart/form-data">
    @csrf
    @if(!empty($group))
        @method('PATCH')
    @endif
    <input type="hidden" id="id" value="{{ $group->id ?? '' }}"/>
    <x-form.input label="Name" name="name" placeholder="Name" value="{{ $group->name ?? '' }}"/>
    <x-form.textarea label="Description" name="description" value="{{ $group->description ?? '' }}"/>
    <x-form.radio label="Status" name="status" :datas="$status" value="{{ $group->status ?? '' }}"/>
    <div class="table-responsive border rounded mt-1">
        <h6 class="py-1 mx-1 mb-0 font-medium-2">
            <i data-feather="lock" class="font-medium-3 mr-25"></i>
            <span class="align-middle">Permission Modul</span>
        </h6>
        <table class="table table-striped table-borderless">
            <thead class="thead-light">
            <tr>
                <th>Module</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($moduls as $key => $modul)
                @php
                $checked = "";
                if(!empty($groupModuls)){
                    if(in_array($modul->id,$groupModuls))
                        $checked = "checked";
                }
                @endphp
            <tr>
                <td>{{ $modul->name }}</td>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="moduls[{{ $modul->id }}]" id="moduls[{{ $modul->id }}]"
                               {!! $checked !!} />
                        <label class="custom-control-label" for="moduls[{{ $modul->id }}]"></label>
                    </div>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <br/>
    <input type="submit" class="btn btn-primary " style="width: 100%" value="Save"/>
</form>
