@if($label)
    <div class="form-group">
    <label class="d-block mb-1">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
    @foreach($datas as $key => $values)
        <div {{ $attributes->merge(['class' => 'custom-control custom-radio custom-control-inline '.$class]) }}
        @if($event)
            onclick="{{ $event }}"
        @endif
        style="margin-bottom: 3px;">
            @php
            $value = empty($value) ? $key : $value;
            @endphp
            <input type="radio"
                   id="{{ $name.'_'.$key }}"
                   name="{{ $name }}"
                   value="{{ $key }}"
                   class="custom-control-input col-md-4"
                {{ $value == $key || $key == old($name) ? "checked=checked" : "" }}
            />
            <label class="custom-control-label" for="{{ $name.'_'.$key }}">{{ $values }}</label>
        </div>
    @endforeach
</div>
@else
    @foreach($datas as $key => $values)
        <div {{ $attributes->merge(['class' => 'custom-control custom-radio custom-control-inline '.$class]) }}
             @if($event)
             onclick="{{ $event }}"
             @endif
             style="margin-bottom: 3px;">
            @php
                $value = empty($value) ? $key : $value;
            @endphp
            <input type="radio"
                   id="{{ $name.'_'.$key }}"
                   name="{{ $name }}"
                   value="{{ $key }}"
                   class="custom-control-input col-md-4"
                    {{ $value == $key || $key == old($name) ? "checked=checked" : "" }}
            />
            <label class="custom-control-label" for="{{ $name.'_'.$key }}">{{ $values }}</label>
        </div>
    @endforeach
@endif

