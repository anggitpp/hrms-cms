@php
    $class = empty($class) ? 'col-md-2' : $class;
   date_default_timezone_set('Asia/Jakarta')
@endphp

<div class="form-group">
    <label for="fp-time">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
    <div class="input-group input-group-merge" >
        <div class="input-group-prepend">
            <span class="input-group-text"><i data-feather='clock'></i></span>
        </div>
    <input type="text"
           id="{{ $name }}"
           name="{{ $name }}"
           {{ $attributes->merge(['class' => 'form-control flatpickr-time text-left flatpickr-input active '.$class]) }}
           value="{{ empty($value) ? empty(old($name)) ? '' : old($name) : $value }}"
           readonly="readonly">
    </div>
    @if($required)
        <div class="invalid-feedback" id="{{ $name }}-error"></div>
    @endif
</div>
