@php
    $url = "/payrolls/process/";
@endphp
@extends('app')
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <form class="form-inline" method="GET" id="form">
                <x-form.input name="filter" class="mr-1" value="{{ $filter }}" placeholder="Search .."/>
                <input type="submit" class="btn btn-primary" value="GO">
            </form>
            @if(!isset($process) || $process->approve_status != 't')
                <div class="form-inline">
                    <button class="btn btn-outline-primary waves-effect btnLoading" type="button" disabled="" style="display: none">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="ms-25 align-middle">Loading...</span>
                    </button>
                    <buton href="{{ route('payrolls.process.update', [$typeId, $month, $year]) }}" class="btn btn-primary ml-2 btnProcess"><i data-feather='repeat'></i> Proses Gaji - {{ numToMonth($month)." ".$year }}</buton>
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="*">Nama</th>
                    <th width="20%" class="text-center">NIK</th>
                    <th width="10%">Nilai</th>
                </tr>
                </thead>
                <tbody>
                @if(!$details->isEmpty())
                    @foreach($details as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $r->name }}</td>
                        <td class="text-center">{{ $r->emp_number }}</td>
                        <td class="text-right">
                            <a href="#" class="btn-modal-form" data-url="{{ $url }}" data-action="detail" data-id="{{ $r->processId."/".$r->id }}">
                                {{ setCurrency($r->value) }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" align="center">-- Empty Data --</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            {{ generatePagination($details) }}
        </div>
    </div>
    <form action="" id="formUpdate" method="POST">
        @csrf
        @method('POST')
        <input type="submit" style="display: none">
    </form>
    <x-modal-form  size="modal-xl" title="Slip Gaji"/>
@endsection
@section('scripts')
    <script>
        $('.btnProcess').on('click', function (){
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you sure?',
                text: "Untuk proses gaji Januari 2022?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formUpdate').action = link;
                    document.getElementById('formUpdate').submit();
                    $('.btnProcess').hide();
                    $('.btnLoading').show();
                }

            })
        });
    </script>
@endsection
