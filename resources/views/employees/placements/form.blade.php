@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            &nbsp;
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($placement) ? route('employees.placements.store') : route('employees.placements.update', $placement->id) }}">
                @csrf
                @if(!empty($placement))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Penempatan</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" required name="name" value="{{ $placement->name ?? '' }}"/>
                        <x-form.select label="Atasan" name="leader_id" required :datas="$employees" options="- Pilih Atasan -" value="{{ $placement->leader_id ?? '' }}" />
                        <x-form.select label="Admin / Tata Usaha" name="administration_id" required :datas="$employees" options="- Pilih Admin -" value="{{ $placement->administration_id ?? '' }}" />
                        <x-form.textarea label="Keterangan" name="description" value="{{ $placement->description ?? '' }}"/>
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $placement->status ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#employee_id').on('change', function (){
            $.ajax({
                url: 'getDetail/'+ this.value,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#emp_number').val(data['emp_number']);
                    $('#position_id').val(data['positionName']);
                    $('#rank_id').val(data['rankName']);
                },
            });
        });
    </script>
@endsection
