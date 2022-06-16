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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($master) ? route('bms.'.$arrMenu['target'].'.activity.store', $id) : route('bms.'.$arrMenu['target'].'.activity.update', $id) }}">
                @csrf
                @if(!empty($master))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Master Aktifitas</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="Obyek" required name="object_id" :datas="$objects" value="{{ $master->object_id ?? $id }}" event="getSub(this.value, 'target_id', 'getTargets');"/>
                        <x-form.select label="Kategori" name="category_id" :datas="$categories" options="- Pilih Kategori -" value="{{ $master->category_id ?? '' }}"/>
                        <x-form.radio label="Kontrol Model" name="control_type" :datas="$controlType" value="{{ $master->control_type ?? '' }}" event="setParameter();"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="Sub Obyek" required name="target_id" :datas="$subobjects" options="- Pilih Sub Obyek -" value="{{ $master->target_id ?? $targetId }}"/>
                        <x-form.input label="Aktifitas" name="name" required placeholder="Nama" value="{{ $master->name ?? '' }}"/>
                        <x-form.input label="Kode" name="code" readonly value="{{ $master->code ?? $lastCode }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="parameter" style="{{ !empty($master->control_type) && $master->control_type == 2 ? 'display:block' : 'display:none' }}">
                            <x-form.input label="Parameter" name="control_parameter" value="{{ $master->control_parameter ?? '' }}" />
                        </div>
                        <div id="range" style="{{ !empty($master->control_type) && $master->control_type == 3 ? 'display:block' : 'display:none' }}">
                            <x-form.double-input label="Dari" label2="Sampai" name="range_1" name2="range_2" value="{{ $master->range_1 ?? '' }}" value2="{{ $master->range_2 ?? '' }}" />
                        </div>
                        <x-form.select label="Interval" required name="interval_id" :datas="$masters['BKIV']" options="- Pilih Interval -" value="{{ $master->interval_id ?? '' }}"/>
                        <x-form.textarea label="Description" name="description" value="{{ $master->description ?? '' }}" />
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $master->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <div id="divUnit" style="{{ !empty($master->control_type) && $master->control_type != 1 ? 'display:block' : 'display:none' }}">
                            <x-form.select label="Satuan" name="control_unit_id" :datas="$masters['BKST']" options="- Pilih Satuan -" value="{{ $master->control_unit_id ?? '' }}" style="display: none" />
                        </div>
                        <x-form.input label="Urutan" class="col-md-2" style="text-align: right" name="order" readonly value="{{ $master->order ?? $lastOrder + 1 }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setParameter(){
            val = document.querySelector('input[name="control_type"]:checked').value;
            divParameter = document.getElementById('parameter');
            divRange = document.getElementById('range');
            divUnit = document.getElementById('divUnit');
            if(val == 2){
                divParameter.style.display = 'block';
                divUnit.style.display = 'block';
                range.style.display = 'none';
            }else if(val == 3){
                divParameter.style.display = 'none';
                divUnit.style.display = 'block';
                range.style.display = 'block';
            }else{
                divParameter.style.display = 'none';
                divUnit.style.display = 'none';
                range.style.display = 'none';
            }
        }
        $('#target_id').on('change', function (){
            objectId = $('#object_id').val();
            $.ajax({
                url: '/activity/housekeeping/getLastOrder/'+ objectId + '/' + this.value,
                type: "GET",
                success: function (data) {
                    $('#order').val(data);
                },
            });
        });
    </script>
@endsection
