@extends('app')
@section('content')
    @php
    $url = '/settings/parameters/';
    @endphp
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            <button class="btn btn-primary btn-modal" data-toggle="modal" data-action="create" data-url="{{ $url }}">
                <i data-feather='plus'></i> Add Parameter
            </button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="10%">Code</th>
                    <th width="20%">Name</th>
                    <th width="30%">Value</th>
                    <th width="25%">Description</th>
                    <th width="10%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$parameters->isEmpty())
                    @foreach($parameters as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->code }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->value }}</td>
                            <td>{{ $r->description }}</td>
                            <td>
                                <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="{{ $url }}" data-action="edit">
                                    <i data-feather="edit"></i>
                                </a>
                                <button href="{{ route('settings.parameters.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            {{ generatePagination($parameters) }}
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <x-side-modal-form title="Form Parameter"/>
@endsection
