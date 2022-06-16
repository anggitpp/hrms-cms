@php
$url = '/employees/'.$arrMenu['target'].'/family/';
@endphp
<div class="card">
    <div class="card-header justify-content-between">
        &nbsp;
        @if(isset($access['family/create']))
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-id="{{ $id }}" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Tambah Keluarga
            </button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="*">Nama</th>
                <th width="10%">Hubungan</th>
                <th width="15%">No. KTP</th>
                <th width="13%">Gender</th>
                <th width="14%">Tgl Lahir</th>
                <th width="10%" style="text-align: center">File</th>
                <th width="13%" style="text-align: center">Kontrol</th>
            </tr>
            </thead>
            <tbody>
            @if(!$families->isEmpty())
                @foreach($families as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $masters['EHK'][$r->relation_id] }}</td>
                        <td>{{ $r->identity_number }}</td>
                        <td>{{ $r->gender == 'f' ?  'Perempuan'  : 'Laki-Laki' }}</td>
                        <td>{{ $r->birth_date == '0000-00-00' ? '' : setDate($r->birth_date) }}</td>
                        <td align="center">
                            @if($r->filename)
                                <a href="{{ asset('storage'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                            @endif
                        </td>
                        @if(isset($access['family/edit']) || isset($access['family/destroy']))
                            <td align="center">
                                @if(isset($access['family/edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['family/destroy']))
                                    <button href="{{ route('employees.'.$arrMenu['target'].'.family.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" align="center">-- Empty Data --</td>
                </tr>
            @endif
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        {{ generatePagination($families) }}
        <form action="" id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" style="display: none">
        </form>
    </div>
</div>
