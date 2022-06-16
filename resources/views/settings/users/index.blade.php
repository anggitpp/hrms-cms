@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(isset($access['create']))
                <button class="btn btn-primary btn-modal" data-toggle="modal" data-form="menu" data-action="create" data-url="/settings/users/">
                    <i data-feather='plus'></i> Add User
                </button>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="5%">PIC</th>
                    <th width="5%">Username</th>
                    <th width="*">Name</th>
                    <th width="10%">Phone Number</th>
                    <th width="15%">User Group</th>
                    <th width="15%">Last Login</th>
                    <th width="5%">Status</th>
                    @if(isset($access['edit']) || isset($access['destroy']))
                        <th style="text-align: center" width="13%">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @if(!$users->isEmpty())
                    @foreach($users as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>
                                <div class="avatar-wrapper">
                                    <div class="avatar mr-1">
                                        <img src="{{ $r->picture ? asset('storage/'.$r->picture) : asset('storage/uploads/images/nophoto.png') }}" style="height: 32px; width: 32px">
                                    </div>
                                </div>
                            </td>
                            <td>{{ $r->username }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->phone_number ?? '' }}</td>
                            <td>{{ $r->group->name ?? '' }}</td>
                            <td>{{ $r->last_login }}</td>
                            <td>
                                <div class="badge badge-{{ $r->status == 't' ? 'success' : 'danger' }}">{{ $r->status == 't' ? 'Aktif' : 'Tidak Aktif' }}</div>
                            </td>
                            @if(isset($access['edit']) || isset($access['destroy']))
                                <td align="center">
                                    <a href="#" class="btn btn-icon btn-success btn-modal-form" data-form-id="modul" data-id="{{ $r->id }}" data-url="/settings/users/" data-action="editPassword">
                                        <i data-feather="settings"></i>
                                    </a>
                                    @if(isset($access['edit']))
                                        <a href="#" class="btn btn-icon btn-primary btn-modal" data-form-id="modul" data-id="{{ $r->id }}" data-url="/settings/users/" data-action="edit">
                                            <i data-feather="edit"></i>
                                        </a>
                                    @endif
                                    @if(isset($access['destroy']))
                                        <button href="{{ route('settings.users.destroy', $r->id) }}" id="delete" class="btn btn-icon btn-danger">
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
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
        {{ generatePagination($users) }}
    </div>
    <x-side-modal-form title="Form Menu"/>
    <x-modal-form title="Ubah Password"/>
@endsection
