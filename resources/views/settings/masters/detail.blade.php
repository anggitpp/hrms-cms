@extends('app')
@section('content')
    @php
        $url = '/settings/masters/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                @if(isset($parents))
                    <x-form.select name="filterParent" class="mr-1" options="- All Parent -" :datas="$parents" value="{{ $filterParent ?? '' }}" event="document.getElementById('form').submit();"/>
                @endif
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="master/create" data-url="{{ $url }}" data-id="{{ $id }}">
                <i data-feather='plus'></i> Add Master
            </button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Name</th>
                    <th width="10%">Code</th>
                    <th width="30%">Description</th>
                    <th width="5%">status</th>
                    <th width="5%">Order</th>
                    <th style="text-align: center" width="13%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$masters->isEmpty())
                    @foreach($masters as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $r->description }}</td>
                            <td>
                                <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                            </td>
                            <td align="right">{{ $r->order }}</td>
                            <td align="center">
                                <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="master/edit">
                                    <i data-feather="edit"></i>
                                </a>
                                <button href="{{ route('settings.masters.master.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($masters) }}
            <br>
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Modul"/>
@endsection
