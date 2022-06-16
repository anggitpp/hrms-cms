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
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($component) ? route('payrolls.'.$arrMenu['target'].'.store', $id) : route('payrolls.'.$arrMenu['target'].'.update', $component->id) }}">
                @csrf
                @if(!empty($component))
                    @method('PATCH')
                @endif
                <div class="card-title">
                    <h5>Data Komponen</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Master Gaji" name="" readonly value="{{ $type->name }}"/>
                        <x-form.input label="Nama" required name="name" value="{{ $component->name ?? '' }}"/>
                        <x-form.textarea label="Keterangan" name="description" value="{{ $component->description ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Komponen" name="" readonly value="{{ $componentType }}"/>
                        <x-form.input label="Kode" required name="code" class="col-md-2" value="{{ $component->code ?? '' }}"/>
                        <x-form.input label="Urutan" name="order" readonly class="col-md-2" value="{{ $component->order ?? $lastOrder }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.radio label="Method" name="component_method" :datas="$methods" value="{{ $component->method ?? '' }}" event="setParameter()"/>
                        <div id="divInput" style="{{ isset($component->method) ? $component->method == 1 ? 'display:none' : 'display:block' : 'display:none' }}">
                            <x-form.input label="Nilai" name="method_value" class="col-md-4" value="{{ $component->method_value ?? '' }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-form.radio label="Status" name="status" :datas="$status" value="{{ $component->status ?? '' }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setParameter(){
            val = document.querySelector('input[name="component_method"]:checked').value;
            inputValue = document.getElementById('divInput');
            if(val == 1){
                inputValue.style.display = 'none';
            }else{
                inputValue.style.display = 'block';
            }
        }
    </script>
@endsection
