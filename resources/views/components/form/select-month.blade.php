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
            @for($i = 1; $i<=12; $i++)
                <option value="{{ $i }}" {{ $i == $value ? 'selected' : '' }} >{{ numToMonth($i) }}</option>
            @endfor
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
            @for($i = 1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ $i == $value ? 'selected' : '' }} >{{ numToMonth($i) }}</option>
            @endfor
        </select>
    </div>
@endif
<script type="text/css">
    .select2-container{ width: 10% !important; }
</script>
