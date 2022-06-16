@php
    $url = '/recruitments/applicants/education/';
@endphp
<div class="card">
    <div class="card-header justify-content-between">
        &nbsp;
        @if(isset($access['education/create']))
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-id="{{ $id }}" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Tambah Pendidikan
            </button>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="10%">Tingkatan</th>
                <th width="*">Institut</th>
                <th width="15%">Jurusan</th>
                <th width="15%">Periode</th>
                <th width="15%">Kota</th>
                <th width="5%" style="text-align: center">File</th>
                <th width="15%" style="text-align: center">Kontrol</th>
            </tr>
            </thead>
            <tbody>
            @if(!$education->isEmpty())
                @foreach($education as $key => $r)
                    @php
                    @endphp
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $masters['SPD'][$r->level_id] ?? '' }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->major }}</td>
                        <td>{{ $r->start_year.' - '.(empty($r->end_year) ? 'current' : $r->end_year) }}</td>
                        <td>{{ $r->city }}</td>
                        <td align="center">
                            @if($r->filename)
                                <a href="{{ asset('storage/'.$r->filename) }}" download>{!! getIcon($r->filename) !!}</a>
                            @endif
                        </td>
                        @if(isset($access['education/edit']) || isset($access['education/destroy']))
                            <td align="center">
                                @if(isset($access['education/edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                                @if(isset($access['education/destroy']))
                                    <button href="{{ route('recruitments.applicants.education.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
        {{ generatePagination($education) }}
        <form action="" id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" style="display: none">
        </form>
    </div>
</div>
