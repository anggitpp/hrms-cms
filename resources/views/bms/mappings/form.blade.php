@extends('app')
@section('content')
    <div class="card">
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="row justify-content-center">
                &nbsp;
                <img class="img-fluid rounded" src="{{ asset( $emp->photo ? 'storage/'.$emp->photo : 'storage/nophoto.png') }}" height="150" width="150" style="max-width:100%;max-height:100%;" alt="User avatar"/>
            </div>
            <div style="position: absolute; top: 5px; right: 10px">
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" style="height: 40px;" class="btn btn-outline-secondary mr-1">Kembali</a>
            </div>
            <br>
            <div class="row justify-content-center">
                <h4>{{ $emp->name }} <span style="color: darkgray; font-size: 15px;"> ({{ $emp->nickname }})</span></h4>
            </div>
            <div class="row justify-content-center">
                <h6><i>{{ $emp->emp_number }}</i></h6>
            </div>
            <div class="row justify-content-center">
                <h6><i>{{ $masters['EP'][$emp->contract->rank_id] }}</i></h6>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($emp) ? route('bms.mappings.store') : route('bms.mappings.update', $emp->id) }}">
                @csrf
                @if(!empty($emp))
                    @method('PATCH')
                @endif
                @foreach($areas as $key => $values)
                <div class="card-title">
                    <h5>{{ $masters['ELK'][$key] }}</h5>
                    <hr>
                </div>
                <table class="table table-striped table-borderless">
                    <thead class="thead-light">
                    <tr>
                        <th width="*">Building</th>
                        <th style="text-align: center" width="15%">Housekeeping</th>
                        <th style="text-align: center" width="15%">Security</th>
                        <th style="text-align: center" width="15%">Front Desk</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($values as $k => $name)
                            @php
                            if(!empty($areaAccess[$key][$k])){
                                $list[$key][$k] = explode(",", $areaAccess[$key][$k]);
                            }
                            @endphp
                        <tr>
                            <td>{{ $name }}</td>
                            <td>
                                <div class="container text-center">
                                    <div class="custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input"
                                           value="housekeeping"
                                           name="services[{{ $key }}][{{ $k }}][]"
                                           id="housekeeping[{{ $key }}][{{ $k }}]"
                                           @if(!empty($list[$key][$k]))
                                                @if(in_array('housekeeping', $list[$key][$k]))
                                                    checked
                                                @endif
                                            @endif
                                     />
                                        <label class="custom-control-label" for="housekeeping[{{ $key }}][{{ $k }}]"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="container text-center">
                                    <div class="custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input"
                                               value="security"
                                               name="services[{{ $key }}][{{ $k }}][]"
                                               id="security[{{ $key }}][{{ $k }}]"
                                               @if(!empty($list[$key][$k]))
                                                   @if(in_array('security', $list[$key][$k]))
                                                       checked
                                                    @endif
                                                @endif
                                        />
                                        <label class="custom-control-label" for="security[{{ $key }}][{{ $k }}]"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="container text-center">
                                    <div class="custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input"
                                               value="frontdesk"
                                               name="services[{{ $key }}][{{ $k }}][]"
                                               id="frontdesk[{{ $key }}][{{ $k }}]"
                                               @if(!empty($list[$key][$k]))
                                                   @if(in_array('frontdesk', $list[$key][$k]))
                                                       checked
                                                    @endif
                                                @endif
                                        />
                                        <label class="custom-control-label" for="frontdesk[{{ $key }}][{{ $k }}]"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br/>
                @endforeach
            </form>
        </div>
    </div>
    <style>
        .custom-checkbox {
            text-align: center !important;
            align-content: center !important;
            align-items: center !important;
        }
        .custom-control {
            text-align: center !important;
            align-content: center !important;
            align-items: center !important;
        }
    </style>
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
