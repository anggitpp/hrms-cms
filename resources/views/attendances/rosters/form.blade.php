@extends('app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12">
                <div class="row justify-content-between">
                    &nbsp;
                    <img class="img-fluid rounded" src="{{ asset( $emp->photo ? 'storage/'.$emp->photo : 'storage/nophoto.png') }}" height="104" width="104" style="max-width:100%;max-height:100%;" alt="User avatar"/>
                    <a href="{{ route('attendances.rosters.index') }}" style="height: 40px !important;" class="btn btn-outline-secondary mr-1">Kembali</a>
                </div>
                <br>
                <div class="row justify-content-center">
                    <h4>{{ $emp->name }} <span style="color: darkgray; font-size: 15px;">({{ $emp->nickname }})</span></h4>
                </div>
                <div class="row justify-content-center">
                    <h6><i>{{ $emp->emp_number }} - {{ isset($empc->position_id) ? $masters[$empc->position_id] : '' }}</i></h6>
                </div>
            </div>
            <br>
            <div class="justify-content-between d-flex">
                <div class="justify-content-center align-self-end">
                    <div class="mr-1">
                        <form class="form-inline" method="GET" id="formFilter">
                            <x-form.select-month name="filterMonth" event="document.getElementById('formFilter').submit();" value="{{ $filterMonth }}" />
                            <x-form.select-year name="filterYear" event="document.getElementById('formFilter').submit();" value="{{ $filterYear }}" />
                        </form>
                    </div>
                </div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
            </div>
            <hr>
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('attendances.rosters.update', $emp->id) }}">
                <input type="hidden" name="monthValue" value="{{ $filterMonth }}" />
                <input type="hidden" name="yearValue" value="{{ $filterYear }}"/>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%">Tanggal</th>
                            <th width="20%">Shift</th>
                            <th width="15%">Mulai</th>
                            <th width="15%">Selesai</th>
                            <th width="*">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @csrf
                        @method('PATCH')
                        @for($i = 1; $i<=$totalDay; $i++)
                            @php
                                $day = $i < 10 ? '0'.$i : $i;
                                $date = implode('-', array($filterYear, $filterMonth, $day));
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{!! setDate($date, 't') !!}</td>
                                <td>
                                    <x-form.select name="shift_id_[{{ $i }}]" :datas="$shifts" options="- Pilih Shift -" value="{{ $rosters[$i - 1]->shift_id ?? $shift->id  }}"
                                    event="getDetail(this.value, {{ $i }});"/>
                                </td>
                                <td>
                                    <x-form.timepicker name="start_[{{ $i }}]" class="col-md-6" value="{{ $rosters[$i - 1]->start ?? $shift->start }}" />
                                </td>
                                <td>
                                    <x-form.timepicker name="end_[{{ $i }}]" class="col-md-6" value="{{ $rosters[$i - 1]->end ?? $shift->end }}" />
                                </td>
                                <td>
                                    <x-form.input name="description_[{{ $i }}]" value="{{ $rosters[$i - 1]->description ?? '' }}" />
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function getDetail(value, order){
            // alert('test' + value + order);
            $.ajax({
                url: '/attendances/rosters/getDetail/'+ value,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    start = data['start'];
                    end = data['end'];
                    $("#start_\\\["+order+"\\\]").val(start.substr(0,5));
                    $("#end_\\\["+order+"\\\]").val(end.substr(0,5));
                },
            });
        };
    </script>
@endsection
