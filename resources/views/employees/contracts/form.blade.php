@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Data</h4>
            <div>
                <button type="reset" class="btn btn-primary mr-1 btn" onclick="document.getElementById('form').submit();">
                    {{ __('label.submit') }}
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-1">{{ __('label.back') }}</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form" enctype="multipart/form-data" method="POST" action="{{ empty($contract) ? route('employees.contracts.store') : route('employees.contracts.update', $contract->id) }}">
                @csrf
                @if(!empty($contract))
                    @method('PATCH')
                @endif
                @php
                if(!empty($contract))
                    if(!empty($emp)){
                        $position = $masters['EJP'][$emp->contract->position_id];
                        $rank = $masters['EP'][$emp->contract->rank_id];
                    }
                @endphp
                <div class="card-title">
                    <h5>{{ __('label.employee data') }}</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="{{ __('label.employee') }}" name="employee_id" required :datas="$employees" options="- {{ __('select-option.choose employee') }} -" value="{{ $contract->employee_id ?? '' }}" />
                        <x-form.input label="{{ __('label.position') }}" name="position_id" readonly value="{{ $position ?? '' }}"/>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="{{ __('label.employee_number') }}" name="emp_number" readonly value="{{ $emp->emp_number ?? '' }}"/>
                        <x-form.input label="{{ __('label.rank') }}" name="rank_id" readonly value="{{ $rank ?? '' }}"/>
                    </div>
                </div>
                <br>
                <div class="card-title">
                    <h5>Contract Data</h5>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.select label="{{ __('label.position') }}" required name="position_id" :datas="$masters['EJP']" options="- {{ __('select-option.choose position') }} -" value="{{ $contract->position_id ?? '' }}" />
                        <x-form.select label="{{ __('label.rank') }}" required name="rank_id" event="getSub(this.value, 'grade_id');" :datas="$masters['EP']" options="- {{ __('select-option.choose rank') }} -" value="{{ $contract->rank_id ?? '' }}" />
                        <x-form.input label="{{ __('label.sk number') }}" name="sk_number" placeholder="{{ __('label.sk number') }}" value="{{ $contract->sk_number ?? '' }}"/>
                        <x-form.datepicker label="{{ __('label.start date') }}" required name="start_date" value="{{ $contract->start_date ?? '' }}" class="col-md-4" />
                        <x-form.select label="{{ __('label.placement') }}" name="placement_id" :datas="$masters['EDP']" options="- {{ __('select-option.choose placement') }} -" value="{{ $contract->placement_id ?? '' }}" />
                        <x-form.file label="{{ __('label.file') }}" name="filename" value="{{ $contract->filename ?? '' }}" />
                        <x-form.radio label="{{ __('label.status') }}" name="status" :datas="$status" value="{{ $contract->status ?? '' }}" />
                    </div>
                    <div class="col-md-6">
                        <x-form.select label="{{ __('label.employment type') }}" required name="type_id" :datas="$masters['ETP']" options="- {{ __('select-option.choose employment type') }} -" value="{{ $contract->type_id ?? '' }}" />
                        <x-form.select label="{{ __('label.grade') }}" name="grade_id" :datas="$masters['EG']" options="- {{ __('select-option.choose grade') }} -" value="{{ $contract->grade_id ?? '' }}" />
                        <x-form.select label="{{ __('label.location') }}" required name="location_id" :datas="$masters['ELK']" options="- {{ __('select-option.choose grade') }} -" value="{{ $contract->location_id ?? '' }}" />
                        <x-form.datepicker label="{{ __('label.end date') }}" name="end_date" value="{{ $contract->end_date ?? '' }}" class="col-md-4" />
                        <x-form.select label="{{ __('label.shift') }}" name="shift_id" :datas="$shifts" options="- {{ __('select-option.choose shift') }} -" value="{{ $contract->shift_id ?? '' }}" />
                        <x-form.input label="{{ __('label.description') }}" name="description" placeholder="{{ __('label.description') }}" value="{{ $contract->description ?? '' }}"/>
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
