@php
    $url = '/employees/'.$arrMenu['target'].'/work/';
@endphp
<div class="card">
    <div class="card-header justify-content-between">
        &nbsp;
        @if(isset($access['work/create']))
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-id="{{ $id }}" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Tambah Riwayat Kerja
            </button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="*">Perusahaan</th>
                <th width="15%">Posisi</th>
                <th width="15%">Tgl Mulai</th>
                <th width="15%">Tgl Selesai</th>
                <th width="10%" style="text-align: center">File</th>
                <th width="13%" style="text-align: center">Kontrol</th>
            </tr>
            </thead>
            <tbody>
            @if(!$works->isEmpty())
                @foreach($works as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $r->company }}</td>
                        <td>{{ $r->position }}</td>
                        <td>{{ setDate($r->start_date) }}</td>
                        <td>{{ $r->end_date ? setDate($r->end_date) : '' }}</td>
                        <td align="center">
                            @if($r->filename)
                                <a href="{{ asset('storage/'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                            @endif
                        </td>
                        @if(isset($access['work/edit']) || isset($access['work/destroy']))
                            <td align="center">
                                @if(isset($access['work/edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['work/destroy']))
                                    <button href="{{ route('employees.'.$arrMenu['target'].'.work.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
        {{ generatePagination($works) }}
        <form action="" id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" style="display: none">
        </form>
    </div>
</div>
