@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($master) ? route('ess.leave_masters.store') : route('ess.leave_masters.update', $master->id) }}">
                @csrf
                @if(!empty($master))
                    @method('PATCH')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Nama" required name="name" value="{{ $master->name ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Mulai" required name="start_date" value="{{ $master->start_date ?? '' }}"/>
                        <x-form.input label="Minimal Masa Kerja (Bulan)" name="working_life" class="col-md-4 text-right" maxlength="3" numeric value="{{ $master->working_life ?? '' }}"/>
                        <x-form.textarea label="Keterangan" name="description" value="{{ $master->description ?? '' }}"/>
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $master->status ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Jumlah" required name="quota" class="col-md-2 text-right" maxlength="3" numeric value="{{ $master->quota ?? '' }}"/>
                        <x-form.datepicker label="Tanggal Selesai" required name="end_date" value="{{ $master->end_date ?? '' }}"/>
                        <x-form.radio label="Gender" name="gender" value="{{ $master->gender ?? '' }}" :datas="$genders" />
                        <x-form.select label="Berlaku Untuk" name="location_id" value="{{ $master->location_id ?? '' }}" :datas="$locations" options="- Semua Lokasi -" />
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
