@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="form-inline">
                Gedung : &nbsp;&nbsp;<x-form.select name="filterBuilding" class="mr-1" :datas="$buildings" value="{{ $filterBuilding }}" event="document.getElementById('form').submit();"/>
            </div>
            <div class="justify-content-between form-inline">
                <a href="{{ route('bms.qr.generateQR') }}" class="btn btn-primary mr-1">Generate QR</a>
            </div>
        </div>
        <div class="card-body form-inline justify-content-start">
            @foreach($areas as $area)
                <div style="width: 10%" class="mr-2">
                    <div>
                        <h5 class="text-center">{{ $area->name }}</h5>
                        <div class="text-center">
                            <a href="{!! asset('storage/uploads/bms/qr/'.$area->id.'.png') !!}" download> <img width="100" height="100" src="{!! asset('storage/uploads/bms/qr/'.$area->id.'.png') !!} "></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
