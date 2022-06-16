@extends('app')
@section('content')
    @php
    $url = '/settings/masters/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <x-form.select name="filterModul" class="mr-1" value="" :datas="$moduls" value="{{ $filterModul }}" event="document.getElementById('form').submit();"/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Add Category
            </button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Name</th>
                    <th width="10%">Parent</th>
                    <th width="10%">Code</th>
                    <th width="30%">Description</th>
                    <th width="5%">Order</th>
                    <th style="text-align: center" width="13%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$categories->isEmpty())
                    @foreach($categories as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td><a href="{{ route('settings.masters.master', $r->code) }}">{{ $r->name }}</a></td>
                            <td>{{ $r->parent->name ?? '' }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $r->description }}</td>
                            <td align="right">{{ $r->order }}</td>
                            <td align="center">
                                <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                    <i data-feather="edit"></i>
                                </a>
                                <button href="{{ route('settings.masters.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($categories) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Master"/>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
