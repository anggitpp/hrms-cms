@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h5>
                {{ $emp->name.' - '.$emp->emp_number }}
            </h5>
            <h5>
                {{ setDate($date, 't') }}
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th class="text-center" width="45%">Jadwal</th>
                        <th class="text-center" width="50%">Aktual</th>
                    </tr>
                </thead>
                <tbody>
                @if(!$monitorings->isEmpty())
                    @foreach($monitorings as $key => $r)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td class="text-center">{{ $r->start }} - {{ $r->end }}</td>
                            <td class="text-center">{{ $r->actual }}</td>
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
            <form action="" id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" style="display: none">
            </form>
        </div>
    </div>
    <style>
        .select2{
            min-width: 150px;
        }
    </style>
@endsection
