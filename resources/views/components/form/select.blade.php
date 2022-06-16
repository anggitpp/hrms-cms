@if($label)
    <div class="form-group">
        <label>{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
        <select name="{{ $name }}"
                class="select2 form-control form-control-lg"
                id="{{ $name }}"
                @if($event)
                onchange="{{ $event }}"
            @endif
        >
            @if($options)
                <option value="">{{ $options }}</option>
            @endif
            @if($all)
                <option value="All">All</option>
            @endif
            @foreach($datas as $key => $values)
                <option value="{{ $key }}" {{ $key == $value || $key == old($name) ? 'selected' : '' }} >{{ $values }}</option>
            @endforeach
        </select>
        @if($required)
            <div class="invalid-feedback" id="{{ $name }}-error"></div>
        @endif
    </div>
@else
    <div class="pr-1">
        <select name="{{ $name }}"
                class="select2 form-control form-control-lg"
                id="{{ $name }}"
                @if($event)
                onchange="{{ $event }}"
            @endif
        >
            @if($options)
                <option value="">{{ $options }}</option>
            @endif
            @if($all)
                <option value="All">All</option>
            @endif
            @foreach($datas as $key => $values)
                <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }} >{{ $values }}</option>
            @endforeach
        </select>
    </div>
@endif
