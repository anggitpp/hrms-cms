@php
    $url = '/recruitments/applicants/contact/';
@endphp
<div class="card">
    <div class="card-header justify-content-between">
        &nbsp;
        @if(isset($access['contact/create']))
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-id="{{ $id }}" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Tambah Kontak
            </button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="*">Nama</th>
                <th width="20%">Hubungan</th>
                <th width="20%">Nomor Handphone</th>
                <th width="15%" style="text-align: center">Kontrol</th>
            </tr>
            </thead>
            <tbody>
            @if(!$contacts->isEmpty())
                @foreach($contacts as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $masters['EHK'][$r->relation_id] }}</td>
                        <td>{{ $r->phone_number }}</td>
                        @if(isset($access['contact/edit']) || isset($access['contact/destroy']))
                            <td align="center">
                                @if(isset($access['contact/edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['contact/destroy']))
                                    <button href="{{ route('recruitments.applicants.contact.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" align="center">-- Empty Data --</td>
                </tr>
            @endif
            </tbody>
            <tfoot>

            </tfoot>
        </table>
        {{ generatePagination($contacts) }}
        <form action="" id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" style="display: none">
        </form>
    </div>
</div>
