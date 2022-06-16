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
                    <th width="*">Name</th>
                    <th width="30%">Description</th>
                    <th width="10%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!$groups->isEmpty())
                    @foreach($groups as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->description }}</td>
                            <td align="center">
                                <a href="{{ route('settings.accesses.edit', $r->id) }}" class="btn btn-icon btn-primary">
                                    <i data-feather="edit"></i>
                                </a>
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
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
        {{ generatePagination($groups) }}
    </div>
@endsection
