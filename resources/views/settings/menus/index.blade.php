@extends('app')
@section('content')
    @php
    $url = '/settings/menus/';
    @endphp
<div class="card">
    <div class="card-header justify-content-between">
        <form class="form-inline" method="GET" id="form">
            <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
            <x-form.select name="filterModul" class="mr-1" value="" :datas="$moduls" value="{{ $filterModul }}" event="document.getElementById('form').submit();"/>
            <x-form.select name="filterSubModul" class="mr-1" value="" :datas="$submoduls" value="{{ $filterSubModul }}" event="document.getElementById('form').submit();"/>
            <input type="submit" class="btn btn-primary" value="GO">
        </form>
        <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-action="create" data-url="{{ $url }}">
            <i data-feather='plus'></i> Add Menu
        </button>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="*">Name</th>
                <th width="10%">Target</th>
                <th width="5%">Permissions</th>
                <th width="5%">Functions</th>
                <th width="5%">status</th>
                <th width="5%">urutan</th>
                <th class="text-center" width="15%">Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(!$menus->isEmpty())
                @foreach($menus as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->target }}</td>
                        <td align="center">
                            <a href="{{ route('settings.menus.permission', $r->id) }}" class="btn btn-icon btn-info btn-modal">
                                <i data-feather='list'></i>
                            </a>
                        </td>
                        <td align="center">
                            <a href="{{ route('settings.menus.functions', $r->id) }}" class="btn btn-icon btn-info btn-modal">
                                <i data-feather='list'></i>
                            </a>
                        </td>
                        <td>
                            <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                        </td>
                        <td align="center">{{ $r->order}}</td>
                        <td align="center">
                            <a href="#" class="btn btn-icon btn-success btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="createChild">
                                <i data-feather="plus-square"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                <i data-feather="edit"></i>
                            </a>
                            @if(!$r->menu->contains('parent_id', $r->id))
                            <button href="{{ route('settings.menus.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
                                <i data-feather="trash-2"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @foreach($r->menu as $k => $v)
                        <tr>
                            <td>{{ $k+2 }}</td>
                            <td><span style="margin-left: 30px;">{{ $v->name }}</span></td>
                            <td>{{ $v->target }}</td>
                            <td align="center">
                                <a href="{{ route('settings.menus.permission', $v->id) }}" class="btn btn-icon btn-info btn-modal">
                                    <i data-feather='list'></i>
                                </a>
                            </td>
                            <td align="center">
                                <a href="{{ route('settings.menus.functions', $v->id) }}" class="btn btn-icon btn-info btn-modal">
                                    <i data-feather='list'></i>
                                </a>
                            </td>
                            <td>
                                <div class="badge badge-{{ $v->status == 't' ? 'success' : 'danger' }}">{{ $v->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                            </td>
                            <td align="center">{{ $v->order}}</td>
                            <td align="center">
                                <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $v->id }}" data-url="{{ $url }}" data-action="edit">
                                    <i data-feather="edit"></i>
                                </a>
                                <button href="{{ route('settings.menus.destroy', $v->id) }}" id="delete" class="btn btn-icon btn-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
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
        {{ generatePagination($menus) }}
        <form action="" id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" style="display: none">
        </form>
    </div>
</div>
<x-side-modal-form title="Form Menu"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
