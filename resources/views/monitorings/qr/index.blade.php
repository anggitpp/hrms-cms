@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Lokasi Kerja</h4>
            <div class="justify-content-between form-inline">
                <a href="{{ route('monitorings.qr.generateQR') }}" class="btn btn-primary mr-1">Generate QR</a>
            </div>
        </div>
        <div class="card-body form-inline justify-content-start">
            @foreach($locations as $r)
                <div style="width: 10%" class="mr-2">
                    <div>
                        <h5 class="text-center">{{ $r->name }}</h5>
                        <div class="text-center">
                            <a href="{!! asset('storage/uploads/monitoring/qr/'.$r->id.'.png') !!}" download> <img width="100" height="100" src="{!! asset('storage/uploads/monitoring/qr/'.$r->id.'.png') !!} "></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
