@if($label)
    <div class="form-group">
        <label for="first-name-vertical">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!} </label>
        <input type="{{ $password ? 'password' : 'text' }}"
               id="{{ $name }}"
               {{ $attributes->merge(['class' => 'form-control '.$class]) }}
               name="{{ $name }}"
               value="{{ empty(old($name)) ? ($currency ? setCurrency($value) : $value) : old($name) }}"
               placeholder="{{ $placeholder }}"
            {{ $nospacing ? 'onkeyup=setNoSpacing(this);' : '' }}
            {{ $numeric ? 'onkeyup=setNumber(this);' : '' }}
            {{ $currency ? 'onkeyup=setCurrency(this);' : '' }}
            {{ $currency ? 'style=text-align:right;' : '' }}
        />
        @if($required)
            <div class="invalid-feedback" id="{{ $name }}-error"></div>
        @endif
    </div>
@else
    <input type="text"
           id="{{ $name }}"
           {{ $attributes->merge(['class' => 'form-control '.$class]) }}
           name="{{ $name }}"
           value="{{ empty($value) ? '' : $value }}"
           placeholder="{{ $placeholder }}"
    />
@endif
