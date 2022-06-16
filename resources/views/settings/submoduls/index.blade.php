@extends('app')
@section('content')
    @php
        $url = '/settings/submoduls/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select name="filterModul" class="mr-1" value="" :datas="$moduls" value="{{ $filterModul }}" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Add Sub Modul
            </button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Name</th>
                    <th width="30%">Description</th>
                    <th width="5%">Order</th>
                    <th width="5%">Status</th>
                    <th style="text-align: center" width="13%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$submoduls->isEmpty())
                    @foreach($submoduls as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->description }}</td>
                            <td align="right">{{ $r->order }}</td>
                            <td>
                                <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                            </td>
                            <td align="center">
                                <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                    <i data-feather="edit"></i>
                                </a>
                                <button href="{{ route('settings.submoduls.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </td>
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
            {{ generatePagination($submoduls) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Modul"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
