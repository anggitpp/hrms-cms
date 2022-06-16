@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="20%">Pangkat</th>
                    <th width="15%" class="text-center">Nilai</th>
                    <th width="*">Deskripsi</th>
                    <th width="13%" style="text-align: center">Kontrol</th>
                </tr>
                </thead>
                <tbody>
                @if(!$salaries->isEmpty())
                    @foreach($salaries as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td class="text-right">{{ setCurrency($r->value) }}</td>
                            <td>{{ $r->description }}</td>
                            <td align="center">
                                @if(isset($access['edit']))
                                    <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="/payrolls/basic-salary/" data-action="edit">
                                        <i data-feather="edit"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            {{ generatePagination($salaries) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Gaji Pokok"/>
@endsection
