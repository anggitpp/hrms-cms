@php
$class = empty($class) ? 'col-md-3' : $class;
@endphp

@if($label)
    <div class="form-group">
        <label for="fp-default">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
        <div class="input-group input-group-merge" >
            <div class="input-group-prepend">
                <span class="input-group-text"><i data-feather='calendar'></i></span>
            </div>
            <input type="text"
                   id="{{ $name }}"
                   name="{{ $name }}"
                   {{ $attributes->merge(['class' => 'form-control flatpickr-basic '.$class]) }}
                   value="{{ empty($value) ? empty(old($name)) ? '' : old($name) : setDate($value) }}"
            />
        </div>
        @if($required)
            <div class="invalid-feedback" id="{{ $name }}-error"></div>
        @endif
    </div>
@else
    <div class="input-group input-group-merge">
        <div class="input-group-prepend">
            <span class="input-group-text"><i data-feather='calendar'></i></span>
        </div>
        <input type="text"
               id="{{ $name }}"
               name="{{ $name }}"
               {{ $attributes->merge(['class' => 'form-control flatpickr-basic '.$class]) }}
               value="{{ empty($value) ? empty(old($name)) ? '' : old($name) : setDate($value) }}"
        />
    </div>
@endif
